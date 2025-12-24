<?php


    class Validator{
        // Regex pour la validation
        private static $strRegex = "/^[a-zA-Z\s]+$/";
        private static $phoneRegex = "/^0[67][0-9]{8}$/";
        private static $emailRegex = "/^[a-zA-Z0-9_-%]+@(gmail|outlook)\.com$/";
        private static $dateRegex = "/^\d{4}-\d{2}-\d{2}$/";


        // validate si le champ et vide
        public static function isNotEmtpy(string $input){
            return !empty($input);
        }

        // valider si la valeur et chaine de caracter
        public static function isstr(string $input){
            return preg_match(self::$strRegex,$input)?true:false;
        }

        // valider si la format de la date
        public static function isValidDate(string $input){
            return preg_match(self::$dateRegex,$input)?true:false;
        }

        // valider si la valeur est an email valide
        public static function validateEmail(string $input){
            return preg_match(self::$emailRegex,$input)?true:false;
        }

        // valider si la valeur est an phone valide
        public static function validatePhone(string $input){
            return preg_match(self::$phoneRegex,$input)?true:false;
        }
        
        // valider si la valeur entre
        public static function sanitize(string $input): string {
        return htmlspecialchars(trim($input));
    }
    }
