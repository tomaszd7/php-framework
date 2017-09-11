<?php

namespace MyApp\Service;

/**
 * Description of MyPageAnalyzer
 *
 * @author tomasz
 */
class MyAnalyzer
{
    private $fields;
    private $props;

    public function __construct(array $props = null)
    {
        $this->props = $props;
    }

    public function setProps(array $props)
    {
        $this->props = $props;
    }

    public function analyze(array $fields): bool
    {
        $this->fields = $fields;
        if ($this->props['analyzer'] === 'not exists') {
            return $this->analyzeExistsNot();
        } else {
            return $this->analyzeExists();
        }
    }

    /*
     * if return true - send email as observed text has changed 
     */

    private function analyzeExists(): bool
    {
        foreach ($this->fields as $field) {
            if (strpos($field['title'], $this->props['parseTitle']) !== false &&
                    strpos($field['value'], $this->props['parseValue']) !== false) {
                return true;
            }
        }
        return false;
    }

    /*
     * it has to check all pairs and not only one - assume title is singe match only
     */

    private function analyzeExistsNot(): bool
    {
        foreach ($this->fields as $field) {
            if (strpos($field['title'], $this->props['parseTitle']) !== false &&
                    strpos($field['value'], $this->props['parseValue']) === false) {
                return true;
            }
        }
        return false;
    }

}
