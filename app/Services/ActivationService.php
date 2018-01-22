<?php
declare(strict_types=1);

namespace App\Services;

use Illuminate\Mail\Mailer;
use App\Repositories\ActivationRepository;
use App\Models\User;
use App\Notifications\ActivationUserNotification;

/**
 * Class ActivationService
 * @package App\Services
 */
class ActivationService
{
    protected $mailer;
    protected $activationRepo;
    private $resendAfter = 24;

    /**
     * ActivationService constructor.
     *
     * @param Mailer $mailer
     * @param ActivationRepository $activationRepo
     */
    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    /**
     * Envoi du mail d'activation
     *
     * @param User $user
     */
    public function sendActivationMail(User $user)
    {
        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        $user->notify(new ActivationUserNotification($token));
    }

    /**
     * Activation d'un utilisateur
     *
     * @param $token
     * @return User
     */
    public function activateUser($token): User
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            $return = null;
        }
        else {
            $user = User::find($activation->user_id);

            $user->activated = true;

            $user->save();

            $this->activationRepo->deleteActivation($token);
            $return = $user;
        }

        return $return;
    }

    /**
     * Vérification d'un renvoi du mail d'activation
     *
     * @param $user
     * @return bool
     */
    private function shouldSend($user): bool
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }

}