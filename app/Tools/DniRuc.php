<?php


namespace App\Tools;

use Peru\Jne\DniFactory;
use Peru\Http\ContextClient;
use Peru\Jne\{Dni, DniParser};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};

class DniRuc
{
    private $tipoDocumento;
    private $numeroDocumento;

    public function __construct(String $tipoDocumento, $numeroDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
        $this->numeroDocumento = $numeroDocumento;
    }

    public function getInfo()
    {
        try {
            if(strtoupper($this->tipoDocumento) === 'DNI') {
                //si el dni no es igual a 8 digitos
                if(strlen($this->numeroDocumento) !== 8) {
                    throw new \Exception("EL DNI {$this->numeroDocumento} debe tener 8 dígitos para poder consultarlo");
                }

                $factory = new DniFactory();
                $cs = $factory->create();
                $persona = $cs->get($this->numeroDocumento);
                if(!$persona) {
                    throw new \Exception("La persona con el DNI {$this->numeroDocumento} no fue encontrada");
                }
                return $persona;
            }else if(strtoupper($this->tipoDocumento) === 'RUC'){

                if(strlen($this->numeroDocumento) !== 11) {
                    throw new \Exception("EL RUC {$this->numeroDocumento} debe tener 11 dígitos para poder consultarlo");
                }

                $cs = new Ruc(new ContextClient(), new RucParser(new HtmlParser()));
                $empresa = $cs->get($this->numeroDocumento);
                if(!$empresa) {
                    throw new \Exception("La empresa con el RUC {$this->numeroDocumento} no fue encontrada");
                }
                return $empresa;
            }else {
                throw new \Exception("El tipo de documento {$this->tipoDocumento} no es válido para consultas");
            }

        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
