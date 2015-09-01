<?php

namespace Dodona\Traits;

use Dodona\Models\Entity;
use Dodona\Models\Status\CheckCategory;
use Dodona\Models\Support\Alert;

trait AreaStatusTrait
{

    /**
     * Get the entity's area alert level.
     *
     * @param CheckCategory $check_category
     * @return Alert
     */
    public function areaStatus(CheckCategory $check_category)
    {
        $result = Alert::find(Alert::BLUE);

        $children = $this->enabledChildren();

        foreach ($children as $child) {
            $status = $this->pickStatusArea($child, $check_category);

            if ($status->id === Alert::RED) {
                $result = Alert::find(Alert::RED);
                break;
            }

            if ($status->id === Alert::AMBER) {
                $result = Alert::find(Alert::AMBER);
            }

            if ($status->id === Alert::GREEN && $result->id === Alert::BLUE) {
                $result = Alert::find(Alert::GREEN);
            }
        }

        return $result;
    }

    /**
     * Returns the status area result depending on the check category id.
     *
     * @param Entity $child
     * @param CheckCategory $check_category
     * @return Alert
     */
    protected function pickStatusArea(Entity $child, CheckCategory $check_category)
    {
        switch ($check_category->id) {
            case CheckCategory::CAPACITY_ID:
                return $child->capacityStatus();
            case CheckCategory::RECOVERABILITY_ID:
                return $child->recoverabilityStatus();
            case CheckCategory::AVAILABILITY_ID:
                return $child->availabilityStatus();
            case CheckCategory::PERFORMANCE_ID:
                return $child->performanceStatus();
            default:
                return Alert::find(Alert::BLUE);
        }
    }

    /**
     * Get the client's capacity status.
     *
     * @return Alert
     */
    public function capacityStatus()
    {
        return $this->areaStatus(CheckCategory::find(CheckCategory::CAPACITY_ID));
    }

    /**
     * Get the client's recoverability status.
     *
     * @return Alert
     */
    public function recoverabilityStatus()
    {
        return $this->areaStatus(CheckCategory::find(CheckCategory::RECOVERABILITY_ID));
    }

    /**
     * Get the client's availability status.
     *
     * @return Alert
     */
    public function availabilityStatus()
    {
        return $this->areaStatus(CheckCategory::find(CheckCategory::AVAILABILITY_ID));
    }

    /**
     * Get the client's performance status.
     *
     * @return Alert
     */
    public function performanceStatus()
    {
        return $this->areaStatus(CheckCategory::find(CheckCategory::PERFORMANCE_ID));
    }
}
