<?php


namespace Zavoca\CoreBundle\Utils;


class ZavocaParameterBag
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * ZavocaParameterBag constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * SHORTCUTS
     */

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->getParameter($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function add($key,$value)
    {
        $this->addParameter($key,$value);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function remove($key)
    {
        return $this->remove($key);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->getParameters();
    }


    /**
     * @param $parameters
     */
    public function updateParameters($parameters)
    {
        foreach ($parameters as $key => $value) {
            if (array_key_exists($key, $this->parameters)) {
                $this->parameters = $value;
            } else {
                $this->addParameter($key, $value);
            }
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function addParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public function getParameter($key)
    {
        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }

        return null;
    }

    /**
     * @param $key
     */
    public function removeParameter($key)
    {
        if (isset($this->parameters[$key])) {
            unset($this->parameters[$key]);
        }
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }
}