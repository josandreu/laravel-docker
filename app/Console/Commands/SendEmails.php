<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *
     * PARA LLAMAR A ESTE COMANDO, DESDE LA CONSOLA:
     *      php artisan email:send {email} {asunto} {--html}
     * PARA LLAMARLO DESDE OTRA PARTE DEL CÓDIGO:
     *      $var = Artisan::call('email:send', [
     *         'email' => 'ejemplo@ej.com',
     *         'subject' => 'Mi asunto' ,
     *         '--html' => true
     *      ]);
     * PARA LLAMARLO DESDE CÓDIGO DESDE 2º PLANO:
     *      $var = Artisan::queue('email:send', [
     *         'email' => 'ejemplo@ej.com',
     *         'subject' => 'Mi asunto' ,
     *         '--html' => true
     *      ]);
     */
    protected $signature = 'email:send {email=jos@josandreu.com} {subject=Correo Laravel} {--html}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mails to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //dd($this->argument()); // para obtener todos los argumentos
        //dd($this->argument('email').' - '.$this->argument('subject')); // obtenemos email y asunto
        //dd($this->option()); // obtenemos las opciones

        $email = $this->argument('email');
        $subject = $this->argument('subject');
        $format = $this->option('html') == true ? 'Formato HTML' : 'Texto plano (no HTML)';

        $this->info(PHP_EOL.'Bienvenido al sistema de envío de email'.PHP_EOL);
        $this->comment('El email introducido es '.$email.PHP_EOL);
        $this->comment('El formato de envío es: '.$format);
        // validamos email, creando un objeto de tipo Validator
        $validador = Validator::make(['email' => $email], ['email' => 'required|email']);
        if($validador->fails()) {
            $errors = $validador->errors();
            $this->error('El email '.$email.' no es correcto '.PHP_EOL.$errors->first('email'));
        } else {
            // mandamos email
            $this->send(['email' => $email, 'subject' => $subject, 'format' => $this->option('html')]);
        }
    }

    // función que llamaremos desde handle()
    protected function send(array $data) {
        if($this->confirm('¿Seguro que quieres enviar el email? ')) {
            $this->info('Configurando email, lanzando disparadores...'.PHP_EOL);
            $numEnvios = 100;
            $this->output->progressStart($numEnvios);
            for ($i = 0; $i < $numEnvios; $i++) {
                // creamos la carpeta emails antes y seguidamente la vista aviso.blade.php (emails.aviso)
                // use ($data) => para poder pasar una variable por referencia a una función anónima
                // $msg es la configuración que pasamos para enviar el mail
                Mail::send('emails.aviso', $data, function($msg) use ($data) {
                    $msg->from('system@laravel.com', 'APP Manager');
                    $msg->to($data['email']);
                });
                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
            $this->info($numEnvios.' mensaje enviados!');
        } else {
            $this->error('Mensaje no enviado!');
        }
    }
}
