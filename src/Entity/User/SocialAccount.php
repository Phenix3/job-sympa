<?php

namespace App\Entity\User;

class SocialAccount
{
    private string $name;

    private string $link;

    public static function makeFromUser(User $user): array
    {
        $socialAccounts = [];
        foreach($user->getRawSocialAccounts() as $sa) {
            $socialAccount = new self();
            $socialAccount->name = $sa['name'];
            $socialAccount->link = $sa['link'];
            $socialAccounts[] = $socialAccount;
        }

        return $socialAccounts;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of link
     *
     * @return  self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }
}
