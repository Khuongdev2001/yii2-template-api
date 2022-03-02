<?php

namespace app\behavior;

use yii\base\Behavior;

class ControllerBehavior extends Behavior
{
    public function attach($owner)
    {
        $this->owner = $owner;
        $owner->on("beforeAction", [$this, "beforeAction_copy"]);
    }
    

    public function beforeAction_copy()
    {
        var_dump("action controller");
    }
}
