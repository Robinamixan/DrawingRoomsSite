<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Questions")
 */
class Question
{
    /**
     * @ORM\Column(type="integer", name="id_question")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_quetion;

    /**
     * @ORM\Column(type="string", length=300, name="question_text")
     */
    private $question_text;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"ALL"}, indexBy="id_answer")
     */
    public $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function setQuestionText(string $text)
    {
        $this->question_text = $text;
    }

    public function setIdQuestion(int $number)
    {
        $this->id_quetion = $number;
    }

    public function addAnswer()
    {
        $text = "sdsdsd";
        $flag = true;
        $answer = new Answer();
        $answer->setAnswerText($text);
        $answer->setFlagRight($flag);
        $answer->setQuestion($this);
        $this->answers[] = $answer;
    }

    public function getQuestionText()
    {
        return $this->question_text;
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function getIdQuestion()
    {
        return $this->id_quetion;
    }
}