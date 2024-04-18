<?php 

namespace App\Shared;

class ErrorHttp
{

    public const MSG_NOT_FOUND = 'not found';

    public const MSG_ERROR =[
        "error" => "error",
        "title" => "Erreur interne du serveur",
        "message" => "La requête envoyée par le navigateur n'a pas pu être traitée.",
        "code" => 500
    ];


    public const MSG_FORM_INVALID =[
        "error" => "form invalid",
        "title" => "Le formulaire est incomplet",
        "message" => "Renseignez bien tous les champs de saisie avant de valider.",
        "code" => 500
    ];



}