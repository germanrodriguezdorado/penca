<?php

namespace AppBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Question\Question;

use AppBundle\Entity\Player;


// Comando: php bin/console make_players


class MakePlayers extends ContainerAwareCommand
{
    private $em;

    protected function configure(){
        $this->setName("make_players")
        ->setDescription("Make random players");
        //->addArgument("Limit", InputArgument::REQUIRED, "How many?");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->em = $this->getContainer()->get("doctrine")->getManager();        
        $output->getFormatter()->setStyle("red", new OutputFormatterStyle("red", "default", array("bold")));
        $output->writeln("<red># DRAFT | PLAYER MAKER #</red>");

        $helper = $this->getHelper("question");
        $question = new Question("How many? (20): ", 20);
        $q = $helper->ask($input, $output, $question);



        for ($i=0; $i < $q; $i++) {             
            $player = new Player();
            $player->setName( $this->getRandom("name") );
            $player->setSurname( $this->getRandom("surname") );
            $player->setValoration( $this->getRandom("valoration") );
            $player->setPosition( $this->getRandom("position") );
            $player->setBirth( $this->getRandom("birth") );
            $this->em->persist($player);
        }




        $this->em->flush();

        
    }


    private function clean($string) {
        $string = trim($string);
        return preg_replace("/[^a-zA-Z0-9\s]/", "", $string); // Removes special chars.
    }



    private function getRandom($field){
        switch ($field) {
            case "name":
                $f_contents = file("web/names.txt"); 
                $line = $f_contents[rand(0, count($f_contents) - 1)]; 
                return $this->clean($line);
                break;
            case "surname":
                $f_contents = file("web/surnames.txt"); 
                $line = $f_contents[rand(0, count($f_contents) - 1)]; 
                return $this->clean($line);
                break;
            case "valoration":
                return rand(50,71);
                break;      
            case "position":
                $positions = array("PO", "LI", "LD", "DEC", "MC", "MCO", "MCI", "MCD", "EXI", "EXD", "DC");
                return $positions[array_rand($positions)];
                break;
            case "birth":                 
                $min = strtotime("19830101");
                $max = strtotime("20021231");
                $val = rand($min, $max);                    
                $date = \DateTime::createFromFormat("Y-m-d", date('Y-m-d', $val));
                return $date;
                break;                                                                     
            
            default:
                # code...
                break;
        }
    }

  
}

