<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class BotConversation extends Conversation
{
    /**
     * First question
     */
    public function hello()
    {
        $question = Question::create("¡Hola! Elige una opción") //Saludamos al usuario
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('¿Quién eres?')->value('who'),//Primera opcion, esta tendra el value who
                Button::create('Tengo dudas con respecto a la empresa')->value('info'), //Segunda opcion, esta tendra el value info
            ]);
        //Cuando el usuario elija la respuesta, se enviará el value aquí:
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'who') {//Si es el value who, contestará con este mensaje
                    $this->say('Soy un chatbot, te ayudo a navegar por esta aplicación, 
                    solo debes escribir "Hola bot"');
                    //Si es el value info, llamaremos a la funcion options
                } else if ($answer->getValue() === 'info'){
                    $this->options();
                }
            }
        });
    }

    public function options(){
        $question = Question::create("¿Qué quieres saber?")//le preguntamos al usuario que quiere saber
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('¿En que consiste la empresa?')->value('hour'),//Opción de hora, con value hour
                Button::create('¿Que tipo de servicios ofrecen?')->value('day'),//Opción de fecha, con value day
            ]);

            return $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    if ($answer->getValue() === 'hour') {//Le muestra la hora la usuario si el value es hour
                        $this->say('Somos una empresa que busca mantener una relación armónica entre las personas, la sociedad y la naturaleza, para contribuir a una mejor calidad de vida.');
                    }else if ($answer->getValue() === 'day'){//Le muestra la hora la usuario si el value es date
                        $this->say('Brindamos soluciones ambientales, para la gestión integral de residuos.');
                    }
                }
            });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->hello();
    }
}