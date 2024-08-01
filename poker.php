<?php


class Carta {
    public $palo;
    public $valor;

    public function __construct($palo, $valor) {
        $this->palo = $palo;
        $this->valor = $valor;
    }

    public function __toString() {
        return "{$this->valor} de {$this->palo}";
    }
}

class Mazo {
    private $cartas = [];

    public function __construct() {
        $palos = ['Corazones', 'Diamantes', 'Tréboles', 'Picas'];
        $valores = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

        foreach ($palos as $palo) {
            foreach ($valores as $valor) {
                $this->cartas[] = new Carta($palo, $valor);
            }
        }
        shuffle($this->cartas);
    }

    public function sacarCarta() {
        return array_pop($this->cartas);
    }
}

class ManoDePoker {
    private $cartas = [];

    public function añadirCarta($carta) {
        $this->cartas[] = $carta;
    }

    public function mostrarMano() {
        foreach ($this->cartas as $carta) {
            echo $carta . PHP_EOL;
        }
    }
}

class JuegoDePoker {
    private $mazo;
    private $jugadores = [];

    public function __construct($numJugadores) {
        $this->mazo = new Mazo();
        for ($i = 0; $i < $numJugadores; $i++) {
            $this->jugadores[] = new ManoDePoker();
        }
    }

    public function repartir() {
        foreach ($this->jugadores as $jugador) {
            for ($i = 0; $i < 5; $i++) {
                $jugador->añadirCarta($this->mazo->sacarCarta());
            }
        }
    }

    public function mostrarManos() {
        foreach ($this->jugadores as $indice => $jugador) {
            echo "Jugador " . ($indice + 1) . ":\n";
            $jugador->mostrarMano();
            echo "\n";
        }
    }
}



function mostrarReglasPoker() {
    $reglas = [
        "Escalera de Color (Straight Flush)" => "Cinco cartas consecutivas del mismo palo.\n",
        "Póker (Four of a Kind)" => "Cuatro cartas del mismo valor.\n",
        "Full House" => "Tres cartas de un valor y dos de otro valor.\n",
        "Color (Flush)" => "Cinco cartas del mismo palo, no consecutivas.\n",
        "Escalera (Straight)" => "Cinco cartas consecutivas de diferentes palos.\n",
        "Trío (Three of a Kind)" => "Tres cartas del mismo valor.\n",
        "Doble Pareja (Two Pair)" => "Dos pares de cartas de diferentes valores.\n",
        "Pareja (One Pair)" => "Dos cartas del mismo valor.\n",
        "Carta Alta (High Card)" => "Cuando no se forma ninguna de las manos anteriores, gana la carta más alta.\n"
    ];

    echo "\nReglas del Póker (de mayor a menor valor):\n\n";

    // Recorrer el array y mostrar cada regla
    foreach ($reglas as $mano => $descripcion) {
        echo "$mano: $descripcion\n";
    }

    echo "\nNota: En caso de empate en la combinación, gana la mano con las cartas de mayor valor.\n";
    echo "El orden de valor de las cartas (de mayor a menor) es: A, K, Q, J, 10, 9, 8, 7, 6, 5, 4, 3, 2.\n\n";
}

// Llamar a la función para mostrar las reglas
mostrarReglasPoker();


echo "Iniciando el Juego de Poker...\n\n\n";
$juego = new JuegoDePoker(2); // Ajusta el número de jugadores según sea necesario
$juego->repartir();
$juego->mostrarManos();
