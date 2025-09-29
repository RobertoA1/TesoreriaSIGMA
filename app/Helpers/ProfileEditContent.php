<?php

namespace App\Helpers;

use App\Helpers\Tables\Component;
use Illuminate\Support\Str;

class ProfileEditContent implements Component
{
    private $user;
    private $profileType;
    private $data;
    private $errors;
    private $title;
    private $subtitle;

    public function __construct($user, $profileType, $data = null, $errors = null, $title = null, $subtitle = null)
    {
        $this->user = $user;
        $this->profileType = $profileType;
        $this->data = $data;
        $this->errors = $errors;
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    public static function create($user, $profileType, $data = null, $errors = null, $title = null, $subtitle = null)
    {
        return new self($user, $profileType, $data, $errors, $title, $subtitle);
    }

    public function render()
    {
        // Verificar que el tipo de perfil tenga un archivo de campos específico
        $profileFieldsPath = resource_path(
            "views/components/profile/fields/" . Str::lower($this->profileType) . "-fields.blade.php"
        );        
        if (!file_exists($profileFieldsPath)) {
            throw new \InvalidArgumentException(
                "No existe el archivo de campos para el perfil tipo: " . Str::lower($this->profileType)
            );
        }

        return view('components.profile.edit-form', [
            'user' => $this->user,
            'profileType' => $this->profileType,
            'data' => $this->data,
            'errors' => $this->errors,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }

    /**
     * Obtener el título dinámico según el tipo de perfil
     */
    public function getProfileTitle()
    {
        $titles = [
            'administrativo' => 'Editar Perfil - Administrativo',
            'familiar' => 'Editar Perfil - Familiar',
            'personal' => 'Editar Perfil - Personal',
        ];

        return $titles[$this->profileType] ?? 'Editar Perfil';
    }

    /**
     * Obtener el subtítulo dinámico según el tipo de perfil
     */
    public function getProfileSubtitle()
    {
        switch ($this->profileType) {
            case 'administrativo':
                return 'Cargo: ' . ($this->data['default']['cargo'] ?? 'N/A');
            case 'familiar':
                return 'DNI: ' . ($this->data['default']['dni'] ?? 'N/A');
            case 'personal':
                return 'Código: ' . ($this->data['default']['codigo_personal'] ?? 'N/A');
            default:
                return 'Perfil de ' . ucfirst($this->profileType);
        }
    }

    /**
     * Obtener los colores del ícono según el tipo de perfil
     */
    public function getProfileColors()
    {
        $colors = [
            'administrativo' => 'from-emerald-500 to-teal-600',
            'familiar' => 'from-pink-500 to-rose-600',
            'personal' => 'from-blue-500 to-purple-600',
        ];

        return $colors[$this->profileType] ?? 'from-blue-500 to-purple-600';
    }

    /**
     * Verificar si existen todos los archivos necesarios
     */
    public static function validateProfileType($profileType)
    {
        $requiredFiles = [
            'base-fields.blade.php',
            'security-section.blade.php',
            "{$profileType}-fields.blade.php"
        ];

        foreach ($requiredFiles as $file) {
            $path = resource_path("views/components/profile/fields/{$file}");
            if (!file_exists($path)) {
                return false;
            }
        }

        return true;
    }
}