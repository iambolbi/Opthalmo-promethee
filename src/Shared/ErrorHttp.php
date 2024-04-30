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


    public const MSG_ROLE_NOT_FOUND =[
        "error" => "role ". self::MSG_NOT_FOUND,
        "title" => "Le rôle est introuvable",
        "message" => "Impossible d'afficher cette page ",
        "code" => 500
    ];


    public const MSG_MEDECIN_NOT_FOUND =[
        "error" => "doctor ". self::MSG_NOT_FOUND,
        "title" => "Le medecin est introuvable",
        "message" => "Impossible d'afficher cette page ",
        "code" => 500
    ];

    public const MSG_USER_NOT_FOUND =[
        "error" => "utilisateur ". self::MSG_NOT_FOUND,
        "title" => "L'utillisateur  est introuvable",
        "message" => "Impossible d'afficher cette page ",
        "code" => 500
    ];
    

    public const MSG_ASSURANCE_NOT_FOUND =[
        "error" => "assurance ". self::MSG_NOT_FOUND,
        "title" => "L'assurance  est introuvable",
        "message" => "Impossible d'afficher cette page ",
        "code" => 500
    ];


    public const MSG_PRESTATION_NOT_FOUND =[
        "error" => "prestation ". self::MSG_NOT_FOUND,
        "title" => "La prestation  est introuvable",
        "message" => "Impossible d'afficher cette page ",
        "code" => 500
    ];

}