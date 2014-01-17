<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthUtenti
 *
 * @ORM\Table(name="auth_utenti", indexes={@ORM\Index(name="Cognome_e_Nome", columns={"nome"}), @ORM\Index(name="userid", columns={"utente"})})
 * @ORM\Entity
 */
class AuthUtenti
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="utente", type="string", length=25, nullable=true)
     */
    private $utente;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_classe", type="integer", nullable=false)
     */
    private $idClasse = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=25, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=50, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="cognome", type="string", length=50, nullable=true)
     */
    private $cognome;

    /**
     * @var integer
     *
     * @ORM\Column(name="recupero", type="smallint", nullable=false)
     */
    private $recupero = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="prenotazione", type="boolean", nullable=false)
     */
    private $prenotazione = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="punti_fisica", type="integer", nullable=false)
     */
    private $puntiFisica = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="punti_informatica", type="integer", nullable=false)
     */
    private $puntiInformatica = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="punti_matematica", type="integer", nullable=false)
     */
    private $puntiMatematica = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="punti_elettrotecnica", type="integer", nullable=false)
     */
    private $puntiElettrotecnica = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="punti_tecnologia", type="integer", nullable=false)
     */
    private $puntiTecnologia = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="last_ip", type="string", length=20, nullable=true)
     */
    private $lastIp;

    /**
     * @var integer
     *
     * @ORM\Column(name="livello_fisica", type="integer", nullable=false)
     */
    private $livelloFisica = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="livello_informatica", type="integer", nullable=false)
     */
    private $livelloInformatica = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="livello_matematica", type="integer", nullable=false)
     */
    private $livelloMatematica = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="livello_elettrotecnica", type="integer", nullable=false)
     */
    private $livelloElettrotecnica = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="livello_tecnologia", type="integer", nullable=false)
     */
    private $livelloTecnologia = '1';



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set utente
     *
     * @param string $utente
     * @return AuthUtenti
     */
    public function setUtente($utente)
    {
        $this->utente = $utente;

        return $this;
    }

    /**
     * Get utente
     *
     * @return string 
     */
    public function getUtente()
    {
        return $this->utente;
    }

    /**
     * Set idClasse
     *
     * @param integer $idClasse
     * @return AuthUtenti
     */
    public function setIdClasse($idClasse)
    {
        $this->idClasse = $idClasse;

        return $this;
    }

    /**
     * Get idClasse
     *
     * @return integer 
     */
    public function getIdClasse()
    {
        return $this->idClasse;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return AuthUtenti
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return AuthUtenti
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cognome
     *
     * @param string $cognome
     * @return AuthUtenti
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;

        return $this;
    }

    /**
     * Get cognome
     *
     * @return string 
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * Set recupero
     *
     * @param integer $recupero
     * @return AuthUtenti
     */
    public function setRecupero($recupero)
    {
        $this->recupero = $recupero;

        return $this;
    }

    /**
     * Get recupero
     *
     * @return integer 
     */
    public function getRecupero()
    {
        return $this->recupero;
    }

    /**
     * Set prenotazione
     *
     * @param boolean $prenotazione
     * @return AuthUtenti
     */
    public function setPrenotazione($prenotazione)
    {
        $this->prenotazione = $prenotazione;

        return $this;
    }

    /**
     * Get prenotazione
     *
     * @return boolean 
     */
    public function getPrenotazione()
    {
        return $this->prenotazione;
    }

    /**
     * Set puntiFisica
     *
     * @param integer $puntiFisica
     * @return AuthUtenti
     */
    public function setPuntiFisica($puntiFisica)
    {
        $this->puntiFisica = $puntiFisica;

        return $this;
    }

    /**
     * Get puntiFisica
     *
     * @return integer 
     */
    public function getPuntiFisica()
    {
        return $this->puntiFisica;
    }

    /**
     * Set puntiInformatica
     *
     * @param integer $puntiInformatica
     * @return AuthUtenti
     */
    public function setPuntiInformatica($puntiInformatica)
    {
        $this->puntiInformatica = $puntiInformatica;

        return $this;
    }

    /**
     * Get puntiInformatica
     *
     * @return integer 
     */
    public function getPuntiInformatica()
    {
        return $this->puntiInformatica;
    }

    /**
     * Set puntiMatematica
     *
     * @param integer $puntiMatematica
     * @return AuthUtenti
     */
    public function setPuntiMatematica($puntiMatematica)
    {
        $this->puntiMatematica = $puntiMatematica;

        return $this;
    }

    /**
     * Get puntiMatematica
     *
     * @return integer 
     */
    public function getPuntiMatematica()
    {
        return $this->puntiMatematica;
    }

    /**
     * Set puntiElettrotecnica
     *
     * @param integer $puntiElettrotecnica
     * @return AuthUtenti
     */
    public function setPuntiElettrotecnica($puntiElettrotecnica)
    {
        $this->puntiElettrotecnica = $puntiElettrotecnica;

        return $this;
    }

    /**
     * Get puntiElettrotecnica
     *
     * @return integer 
     */
    public function getPuntiElettrotecnica()
    {
        return $this->puntiElettrotecnica;
    }

    /**
     * Set puntiTecnologia
     *
     * @param integer $puntiTecnologia
     * @return AuthUtenti
     */
    public function setPuntiTecnologia($puntiTecnologia)
    {
        $this->puntiTecnologia = $puntiTecnologia;

        return $this;
    }

    /**
     * Get puntiTecnologia
     *
     * @return integer 
     */
    public function getPuntiTecnologia()
    {
        return $this->puntiTecnologia;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return AuthUtenti
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set lastIp
     *
     * @param string $lastIp
     * @return AuthUtenti
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * Get lastIp
     *
     * @return string 
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Set livelloFisica
     *
     * @param integer $livelloFisica
     * @return AuthUtenti
     */
    public function setLivelloFisica($livelloFisica)
    {
        $this->livelloFisica = $livelloFisica;

        return $this;
    }

    /**
     * Get livelloFisica
     *
     * @return integer 
     */
    public function getLivelloFisica()
    {
        return $this->livelloFisica;
    }

    /**
     * Set livelloInformatica
     *
     * @param integer $livelloInformatica
     * @return AuthUtenti
     */
    public function setLivelloInformatica($livelloInformatica)
    {
        $this->livelloInformatica = $livelloInformatica;

        return $this;
    }

    /**
     * Get livelloInformatica
     *
     * @return integer 
     */
    public function getLivelloInformatica()
    {
        return $this->livelloInformatica;
    }

    /**
     * Set livelloMatematica
     *
     * @param integer $livelloMatematica
     * @return AuthUtenti
     */
    public function setLivelloMatematica($livelloMatematica)
    {
        $this->livelloMatematica = $livelloMatematica;

        return $this;
    }

    /**
     * Get livelloMatematica
     *
     * @return integer 
     */
    public function getLivelloMatematica()
    {
        return $this->livelloMatematica;
    }

    /**
     * Set livelloElettrotecnica
     *
     * @param integer $livelloElettrotecnica
     * @return AuthUtenti
     */
    public function setLivelloElettrotecnica($livelloElettrotecnica)
    {
        $this->livelloElettrotecnica = $livelloElettrotecnica;

        return $this;
    }

    /**
     * Get livelloElettrotecnica
     *
     * @return integer 
     */
    public function getLivelloElettrotecnica()
    {
        return $this->livelloElettrotecnica;
    }

    /**
     * Set livelloTecnologia
     *
     * @param integer $livelloTecnologia
     * @return AuthUtenti
     */
    public function setLivelloTecnologia($livelloTecnologia)
    {
        $this->livelloTecnologia = $livelloTecnologia;

        return $this;
    }

    /**
     * Get livelloTecnologia
     *
     * @return integer 
     */
    public function getLivelloTecnologia()
    {
        return $this->livelloTecnologia;
    }
}
