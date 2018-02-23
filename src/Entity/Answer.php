<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Answers")
 */
class Answer
{
    /**
     * @ORM\Column(type="integer", name="id_answer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_answer;

    /**
     * @ORM\Column(type="string", length=100, name="answer_text")
     */
    private $answer_text;

    /**
     * @ORM\Column(type="boolean", name="flag_right", nullable=true)
     */
    private $flag_right;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="id_question", referencedColumnName="id_question")
     */
    private $question;

    public function __construct()
    {
        $this->flag_right = false;
    }

    public function setAnswerText(string $text)
    {
        $this->answer_text = $text;
    }

    public function setFlagRight(bool $flag)
    {
        $this->flag_right = $flag;
    }

    public function setQuestion(Question $question)
    {
        $this->question = $question;
    }

    public function getAnswerText()
    {
        return $this->answer_text;
    }

    public function getFlagRight()
    {
        return $this->flag_right;
    }

    public function getIdAnswer()
    {
        return $this->id_answer;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function __toString()
    {
        return $this->answer_text;
    }
}