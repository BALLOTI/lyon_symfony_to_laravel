<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 22/05/17
 * Time: 16:09
 */

namespace AppBundle\Business;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Subject;
use AppBundle\Entity\User;
use AppBundle\Repository\CommentRepository;
use AppBundle\Repository\SubjectRepository;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\Session;

class Forum
{
    /** @var  UserRepository */
    private $userRepository;

    /** @var  SubjectRepository */
    private $subjectRepository;

    /** @var  CommentRepository */
    private $commentRepository;

    /** @var  Session */
    private $session;

    /** @var  User */
    private $currentUser;

    /** @var  Subject */
    private $currentSubject;

    /** @var  Comment */
    private $currentComment;

    /**
     * Forum constructor.
     * @param UserRepository $userRepository
     * @param SubjectRepository $subjectRepository
     * @param CommentRepository $commentRepository
     * @param Session $session
     */
    public function __construct(UserRepository $userRepository,
                                SubjectRepository $subjectRepository,
                                CommentRepository $commentRepository,
                                Session $session)
    {
        $this->userRepository       = $userRepository;
        $this->subjectRepository    = $subjectRepository;
        $this->commentRepository    = $commentRepository;
        $this->session              = $session;
    }

    public function getAllSubjects()
    {
        return $this->subjectRepository->findAll();
    }

    public function getSubjects()
    {
        if ($this->getCurrentUser() !== null){
            return $this->currentUser->getSubjects();
        }
        return [];
    }

    public function getComments()
    {
        if ($this->getCurrentSubject() !== null){
            return $this->currentSubject->getComments();
        }
        return [];
    }

    public function getUser(){
        if (!isset($this->currentUser)) {
            $this->currentUser = $this->userRepository->find($this->session->get("user")->id);
        }
        return $this->currentUser;
    }

    public function getCurrentSubject()
    {
        if (!isset($this->currentSubject)) {

        }
    }
}