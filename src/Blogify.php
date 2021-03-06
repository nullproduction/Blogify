<?php namespace jorenvanhocht\Blogify;

use jorenvanhocht\Blogify\Models\User;
use jorenvanhocht\Blogify\Models\Role;
use Illuminate\Support\Facades\Config;
use DB;

class Blogify {

    protected $char_sets;

    public function __construct()
    {
        $this->char_sets = config('blogify.blogify.char_sets');
    }

    /**
     * Generate a unique hash
     *
     * @param $table
     * @param int $min_length
     * @param int $max_length
     * @return string
     */
    public function makeUniqueHash( $table, $field, $min_length = 5, $max_length = 20 )
    {
        $hash   = '';
        $minus  = 0;

        // Generate a random length for the hash between the given min and max length
        $rand   = rand($min_length, $max_length);

        for ( $i = 0; $i < $rand; $i++ )
        {
            $char = rand( 0, strlen( $this->char_sets['hash']));

            // When it's not the first char from the char_set make $minus equal to 1
            if( $char != 0 ? $minus = 1 : $minus = 0 );

            // Add the character to the hash
            $hash .= $this->char_sets['hash'][ $char - $minus ];
        }

        // Check if the hash doest not exist in the given table and column
        if ( ! DB::table($table)->where($field, '=', $hash)->get() )
        {
            return $hash;
        }

        $this->makeUniqueHash($table, $field, $min_length, $max_length);
    }

    /**
     * Generate a random password
     *
     * @return string
     */
    public function generatePassword()
    {
        $password   = '';
        $minus      = 0;
        $rand       = rand(4, 10);

        for( $i = 0; $i < $rand; $i++ )
        {
            $char = rand(0, strlen( $this->char_sets['password'] ));

            if ( $char != 0 ? $minus = 1 : $minus = 0 );

            $password .= $this->char_sets['password'][$char - $minus];
        }
        return $password;
    }

    /**
     * Generate a unique username with the users
     * lastname and firstname
     *
     * @param $lastname
     * @param $firstname
     * @param int $itteration
     * @return string
     */
    public function generateUniqueUsername( $lastname, $firstname, $itteration = 0 )
    {
        $username = strtolower( str_replace( ' ', '', $lastname ) . substr( $firstname, 0, 1 ) );

        if ( $itteration != 0 ) $username = $username . $itteration;

        $usernames = count( DB::table('users')->where('username', '=', $username )->get() );

        if ( $usernames > 0 ) return $this->generateUniqueUsername( $lastname, $firstname, $itteration + 1 );

        return $username;
    }

}