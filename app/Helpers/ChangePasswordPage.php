<?php

namespace App\Helpers;

use App\Helpers\Tables\Component;

class ChangePasswordPage implements Component
{
    private $user;
    private $returnUrl;
    private $errors;
    private $successMessage;

    public function __construct($user, $returnUrl = null, $errors = null, $successMessage = null)
    {
        $this->user = $user;
        $this->returnUrl = $returnUrl ?: route('perfil.edit');
        $this->errors = $errors;
        $this->successMessage = $successMessage;
    }

    public static function create($user, $returnUrl = null, $errors = null, $successMessage = null)
    {
        return new self($user, $returnUrl, $errors, $successMessage);
    }

    public function render()
    {
        return view('profile.change-password-form', [
            'user' => $this->user,
            'returnUrl' => $this->returnUrl,
            'errors' => $this->errors,
            'successMessage' => $this->successMessage,
        ]);
    }

    /**
     * Obtener el título de la página
     */
    public function getTitle()
    {
        return 'Cambiar Contraseña';
    }

    /**
     * Obtener el subtítulo de la página
     */
    public function getSubtitle()
    {
        return 'Actualiza tu contraseña de forma segura';
    }

    /**
     * Obtener los colores del ícono
     */
    public function getIconColors()
    {
        return 'from-red-500 to-pink-600';
    }

    /**
     * Obtener la ruta de acción del formulario
     */
    public function getActionRoute()
    {
        return route('perfil.password.update');
    }

    /**
     * Verificar si hay errores
     */
    public function hasErrors()
    {
        return !empty($this->errors) && $this->errors->any();
    }

    /**
     * Verificar si hay mensaje de éxito
     */
    public function hasSuccess()
    {
        return !empty($this->successMessage);
    }
}