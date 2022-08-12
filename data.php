<?php
error_reporting(-1);
$data = $_GET["data"];

class Planet
{
    public $name;
    public $orbit_radius;
    public $angle;
    public $x0 = 620;
    public $y0 = 485;
    public $speed;
    public $planet_radius;

    function __construct($name, $orbit_radius, $planet_radius, $speed)
    {
        $this->name = $name;
        $this->orbit_radius = $orbit_radius;
        $this->planet_radius = $planet_radius;
        $this->speed = $speed;
    }

    function get_coords()
    {
        $this->angle += (M_PI / 270) * $this->speed;
        $x = $this->x0 + $this->orbit_radius * sin($this->angle);
        $y = $this->y0 + $this->orbit_radius * cos($this->angle);
        return array("name" => $this->name, "x" => $x, "y" => $y, "angle" => $this->angle, "planet_radius" => $this->planet_radius);
    }
}

class Solar
{
    public $data;
    public $result = array();
    public $planets = array();

    function __construct($data)
    {
        $this->data = $data;
        $this->planets[] = new Planet("mercury", 124, 7, 2.565);
        $this->planets[] = new Planet("venera", 152, 10, 1.875);
        $this->planets[] = new Planet("earth", 183, 10, 0.4);
        $this->planets[] = new Planet("mars", 212, 8, 1);
        $this->planets[] = new Planet("yupiter", 261, 30, 0.7);
        $this->planets[] = new Planet("saturn", 327, 25, 0.55);
        $this->planets[] = new Planet("uran", 383, 20, 0.38);
        $this->planets[] = new Planet("neptun", 434, 20, 0.3);
        $this->planets[] = new Planet("pluton", 473, 8, 0.25);
        $this->planets[] = new Planet("moon", 21, 3, 6);
    }

    function get_data()
    {
        $m_x0 = 0;
        $m_y0 = 0;
        for ($i = 0; $i < count($this->planets); $i++) {
            if ($this->data[$i][0] == $this->planets[$i]->name) {
                $this->planets[$i]->angle = $this->data[$i][1];
            }
            if ($this->planets[$i]->name == 'earth') {
                $m_x0 = $this->planets[$i]->get_coords()['x'];
                $m_y0 = $this->planets[$i]->get_coords()['y'];

            }
            if ($this->planets[$i]->name == 'moon') {
                $this->planets[$i]->x0 = $m_x0;
                $this->planets[$i]->y0 = $m_y0;
            }
            array_push($this->result, $this->planets[$i]->get_coords());
        }
    }

    function send()
    {
        echo json_encode($this->result);
    }
}

$s = new Solar($data);
$s->get_data();
$s->send();