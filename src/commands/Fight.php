<?php
namespace Emagia\Commands;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\Table;
use Emagia\Characters\CharacterInterface;
use Emagia\Characters\Character;
use Emagia\Characters\Orderus;
use Emagia\Characters\WildBeast;
use Emagia\Skills\SkillInterface;

class Fight extends Command
{
    protected static $defaultName = 'game:start-fight';


    protected function configure() : void 
    {
        $this
            ->setHelp('This command starts the fight between Orderus and a wild beast.')
            ->addArgument('turns', InputArgument::OPTIONAL, 'How many turns should the fight take? (default: 20)');
    }

    private function getTurnsInput(InputInterface $input) : int
    {
        if ($input->getArgument('turns') === null) {
            return 20;
        }

        return $input->getArgument('turns');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $turns = $this->getTurnsInput($input);

        $output->writeln('Orderus encounters a Wild Beast.');
        
        $orderus = new Orderus();
        $wildBeast = new WildBeast();

        $output->writeln('These are the character stats:');
        $this->showCharacterStats($orderus, $wildBeast, $output);

        $output->writeln('The fight will take: ' . $turns . ' turns or until one of the opponents die.');

        $i = 0;
        [$attacker, $defender] = $this->pickFirstOrder($orderus, $wildBeast);
        while (
            $i < $turns 
            && !$attacker->isDead() 
            && !$defender->isDead()
        )
        {
            $output->writeln('<question>Turn ' . $i + 1 . '/' . $turns . '</question>');
            $damage = $this->takeTurn($attacker, $defender, $output);
            $defender->decreaseHealth($damage);
            $remainingHealth = $defender->getStat(Character::STAT_HEALTH)->value;

            if ($remainingHealth <=0)
            {
                $output->writeln('<error>* ' . $defender->getName() . ' died.</error>');
            }
            else
            {
                $output->writeln('<info>* ' . $defender->getName() . ' has ' . $remainingHealth . ' health remaining.</info>');
            }

            $oldAttacker = $attacker;
            $attacker = $defender;
            $defender = $oldAttacker;

            $i++;
        }

        $winner = $this->pickWinner($attacker, $defender);
        $output->writeln('<question>' . $winner->getName() . ' won the fight!</question>');

        return Command::SUCCESS;
    }

    /**
     * Picks the winner based on who has more health.
     */
    private function pickWinner(CharacterInterface $attacker, CharacterInterface $defender) : CharacterInterface
    {
        if ($attacker->getStat(Character::STAT_HEALTH)->value > $defender->getStat(Character::STAT_HEALTH)->value)
            return $attacker;
        else
            return $defender;
    }

    /**
     * Helper method to choose the first attacker.
     */
    private function orderPicker(CharacterInterface $orderus, CharacterInterface $wildBeast, $value)
    {
        $order = [];
        switch($value)
        {
            case -1:
            case 0:
                $order[0] = $orderus;
                $order[1] = $wildBeast;
                break;
            case 1:
                $order[0] = $wildBeast;
                $order[1] = $orderus;
                break;
        }

        return $order;
    }

    /**
     * Picks who is the first attacker based on speed and luck of each character.
     */
    private function pickFirstOrder(CharacterInterface $orderus, CharacterInterface $wildBeast) : array
    {
        
        $speedCmp = $orderus->getStat(Character::STAT_SPEED)->value <=> $wildBeast->getStat(Character::STAT_SPEED)->value;
        $luckCmp = $orderus->getStat(Character::STAT_LUCK)->value <=> $wildBeast->getStat(Character::STAT_LUCK)->value;

        if ($speedCmp === 0)
            return $this->orderPicker($orderus, $wildBeast, $luckCmp);
        else
            return $this->orderPicker($orderus, $wildBeast, $speedCmp);
    }

    /**
     * Helper method used to show the stats of each character.
     */
    private function showCharacterStats(CharacterInterface $orderus, CharacterInterface $wildBeast, OutputInterface $output)
    {
        $orderusStatsMap = $orderus->getStatsMap();
        $wildBeastStatsMap = $wildBeast->getStatsMap();

        $table = new Table($output);
        $table
            ->setHeaders(['Characters', $orderus->getName(), $wildBeast->getName()])
            ->setRows([
                [$orderusStatsMap->getStat(Character::STAT_HEALTH)->name, $orderusStatsMap[Character::STAT_HEALTH], $wildBeastStatsMap[Character::STAT_HEALTH]],
                [$orderusStatsMap->getStat(Character::STAT_STRENGTH)->name, $orderusStatsMap[Character::STAT_STRENGTH], $wildBeastStatsMap[Character::STAT_STRENGTH]],
                [$orderusStatsMap->getStat(Character::STAT_DEFENCE)->name, $orderusStatsMap[Character::STAT_DEFENCE], $wildBeastStatsMap[Character::STAT_DEFENCE]],
                [$orderusStatsMap->getStat(Character::STAT_SPEED)->name, $orderusStatsMap[Character::STAT_SPEED], $wildBeastStatsMap[Character::STAT_SPEED]],
                [$orderusStatsMap->getStat(Character::STAT_LUCK)->name, $orderusStatsMap[Character::STAT_LUCK], $wildBeastStatsMap[Character::STAT_LUCK]],
            ])
        ;
        $table->render();
    }

    /**
     * Executes the turn.
     */
    public function takeTurn(CharacterInterface $attacker, CharacterInterface $defender, OutputInterface $output) : float
    {
        //Calculate damage at the attack based on which skills are used.
        $initialDamage = array_reduce($attacker->getSkills(), function (float $damage, SkillInterface $skill) use ($output, $attacker)
        {
            $newDamage = $skill->onAttack($damage);

            if ($newDamage !== $damage)
            {
                $output->writeln('<comment>* ' . $attacker->getName() . ' activated ' . $skill->getName() . ' skill.</comment>');
            }

            return $newDamage;
        }, $attacker->calculateDamage($defender));

        $output->writeln('<info>* ' . $attacker->getName() . ' is attacking ' . $defender->getName() . ' for ' . $initialDamage . ' damage.</info>');

        //Calculate final damages based on defender skills and evade chance.
        $finalDamage = array_reduce($defender->getSkills(), function (float $damage, SkillInterface $skill) use ($output, $defender)
        {
            $newDamage = $skill->onDefence($damage);

            if ($newDamage !== $damage)
            {
                $output->writeln('<comment>* ' . $defender->getName() . ' activated ' . $skill->getName() . ' skill.</comment>');
            }

            return $newDamage;
        }, $initialDamage);

        $output->writeln('<info>* ' . $attacker->getName() . ' did ' . $finalDamage . ' damage to ' . $defender->getName() . '.</info>');
        return $finalDamage;
    }
}