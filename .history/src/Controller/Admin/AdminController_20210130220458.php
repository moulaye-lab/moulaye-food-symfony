<?php



use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends EasyAdminController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function persistUserEntity(User $user)
    {
        // Avec FOSUserBundle, on faisait comme ça :
        // $this->get('fos_user.user_manager')->updateUser($user, false);
        $this->updatePassword($user);
        parent::persistEntity($user);
    }

    public function updateUserEntity(User $user)
    {
        // Avec FOSUserBundle, on faisait comme ça :
        //$this->get('fos_user.user_manager')->updateUser($user, false);
        $this->updatePassword($user);
        parent::updateEntity($user);
    }

    public function updatePassword(User $user)
    {
        if (!empty($user->getPlainPassword())) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
        }
    }
}