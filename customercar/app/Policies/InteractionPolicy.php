<?php

// app/Policies/InteractionPolicy.php

namespace App\Policies;

use App\Models\Interaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InteractionPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut mettre à jour l'interaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Interaction  $interaction
     * @return bool
     */
    public function update(User $user, Interaction $interaction)
    {
        // Exemple : seul l'utilisateur qui a créé l'interaction peut la mettre à jour
        return $user->id === $interaction->user_id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer l'interaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Interaction  $interaction
     * @return bool
     */
    public function delete(User $user, Interaction $interaction)
    {
        // Exemple : seul l'utilisateur qui a créé l'interaction peut la supprimer
        return $user->id === $interaction->user_id;
    }
}

