<?php

/*
Plugin Name: PokeApi
Plugin URI: https://pokeapi.co/
Description: All the Pokémon data you'll ever need in one place,
Author: Automattic
Author URI: http://guybrush.info/
License: GPLv2 or later
*/

require 'vendor/autoload.php';
use PokePHP\PokeApi;

function getPokemonList(){
  $pokeApi = new PokeApi;
  $json = $pokeApi->resourceList('pokemon', '100', '0');
  $pokemonList =  (array) json_decode($json)->results;
  foreach ($pokemonList as $pokemon) {
    $url = plugin_dir_url(__FILE__);
    $pieces = explode("/", $pokemon->url);
    $pokemon->id =  $pieces[6];
    $pokemon->imageUrl =  "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/".$pokemon->id.".png";
  }
  return $pokemonList;
}

function getPokemon(WP_REST_Request $request){
  $pokeApi = new PokeApi;
  $id = $request['id'];
  $json = $pokeApi->pokemon($id);
  $pokemonInfo = json_decode($json);
  return $pokemonInfo;
}


add_action('rest_api_init', function(){

  register_rest_route('pokeapi/v1', 'pokemon', [
    'methods' => 'GET',
		'callback' => 'getPokemonList',
  ]);

  register_rest_route('pokeapi/v1', 'pokemon/(?P<id>\d+)', [
    'methods' => 'GET',
		'callback' => 'getPokemon',
    'args' => array(
      'id' => array(
        'validate_callback' => function($param, $request, $key) {
          return is_numeric( $param );
        }
      ),
    ),
  ]);

});






 ?>
