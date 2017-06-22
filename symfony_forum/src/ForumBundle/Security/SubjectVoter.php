<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 16/06/17
 * Time: 11:37
 */

namespace ForumBundle\Security;


use ForumBundle\Entity\Subject;
use ForumBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class SubjectVoter extends Voter
{
    const DELETE = "delete";
    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::DELETE))) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Subject) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param Subject $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {

        $user = $token->getUser();
        if (!$user instanceof User) {
            return self::ACCESS_ABSTAIN;
        }

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($subject, $user);
        }
        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Subject $subject, User $user)
    {
        return ($user->getId() === $subject->getUser()->getId());
    }
}