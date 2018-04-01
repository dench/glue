<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 01.04.18
 * Time: 19:06
 */

namespace app\models;

use yii\base\Model;

class PodborForm extends Model
{
    /*public $step_1 = 0;

    public $step_2 = 0;

    public $step_3 = 0;

    public $step_4 = 0;

    public $step_5 = 0;

    public $step_1_title = '';

    public $step_2_title = '';

    public $step_3_title = '';

    public $step_4_title = '';

    public $step_5_title = '';

    public $step_1_list = [];

    public $step_2_list = [];

    public $step_3_list = [];

    public $step_4_list = [];

    public $step_5_list = [];*/

    public $step = [];

    public $label = [];

    public $list = [];

    public function init()
    {
        parent::init();

        $this->step[0] = null;
        $this->label[0] = '?';
        $this->list[0] = Podbor::getParentList($this->step[0]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['step_1', 'step_2', 'step_3', 'step_4', 'step_5'], 'integer'],
            [['step'], 'each', 'rule' => ['integer']],
            [['label'], 'each', 'rule' => ['string']],
            [['list'], 'each', 'rule' => ['each', 'rule' => ['integer']]],
        ];
    }

    public function send()
    {
        foreach ($this->step as $step => $value) {
            echo $step . " = " . $value . "<br>";
            $next = $step + 1;

            if ($value && empty($this->list[$next])) {
                $this->label[$next] = Podbor::getLabelTitle($value);
                $this->list[$next] = Podbor::getParentList($value);
            }
        }

        $step = $this->step;

        foreach ($this->label as $k => $v) {
            if ($v) {
                $this->step[$k] = empty($step[$k]) ? null : $step[$k];
            }
        }

        /*$this->step_1_title = Podbor::getLabelTitle($this->step_1);

        $this->step_2_title = Podbor::getLabelTitle($this->step_2);

        $this->step_3_title = Podbor::getLabelTitle($this->step_3);

        $this->step_4_title = Podbor::getLabelTitle($this->step_4);

        $this->step_5_title = Podbor::getLabelTitle($this->step_5);

        $this->step_1_list = Podbor::getParentList($this->step_1);

        $this->step_2_list = Podbor::getParentList($this->step_2);

        $this->step_3_list = Podbor::getParentList($this->step_3);

        $this->step_4_list = Podbor::getParentList($this->step_4);

        $this->step_5_list = Podbor::getParentList($this->step_5);

        if (empty(Podbor::getParentList(null)[$this->step_1])) {
            $this->step_1 = 0;
        }

        if (empty(Podbor::getParentList($this->step_1)[$this->step_2])) {
            $this->step_2 = 0;
        }

        if (empty(Podbor::getParentList($this->step_2)[$this->step_3])) {
            $this->step_3 = 0;
        }

        if (empty(Podbor::getParentList($this->step_3)[$this->step_4])) {
            $this->step_4 = 0;
        }

        if (empty(Podbor::getParentList($this->step_4)[$this->step_5])) {
            $this->step_5 = 0;
        }*/
    }
}