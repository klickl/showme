<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 31/07/2016
 * Time: 12:28
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Show", mappedBy="author", cascade={"remove"})
     */
    protected $shows;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Add show
     *
     * @param \AppBundle\Entity\Show $show
     *
     * @return User
     */
    public function addShow(\AppBundle\Entity\Show $show)
    {
        $this->shows[] = $show;

        return $this;
    }

    /**
     * Remove show
     *
     * @param \AppBundle\Entity\Show $show
     */
    public function removeShow(\AppBundle\Entity\Show $show)
    {
        $this->shows->removeElement($show);
    }

    /**
     * Get shows
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShows()
    {
        return $this->shows;
    }

    public function getRolesName()
    {
        $roles = $this->getRoles();

        $result = "";

        foreach($roles as $role)
        {
            $result .= $role;
            if($role != end($roles))
            {
                $result .= ", ";
            }
        }
        return $result;
    }
}
