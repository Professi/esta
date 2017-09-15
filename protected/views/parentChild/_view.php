<?php
/**
 * ParentChild _View
 */
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/* @var $this ParentChildController */
/* @var $data ParentChild */
?>
<div class="view">
    <ul class="square">
        <li>
            <?php echo CHtml::encode($data->child->firstname . " " . $data->child->lastname); ?>
            &nbsp;
            <?php if (Yii::app()->params['allowParentsToManageChilds'] || Yii::app()->user->checkAccess(MANAGEMENT)) {
    ?> 
                <a href="index.php?r=parentChild/delete&id=<?php echo $data->id ?>" class="delete-children">
                    <i class="fi-x-circle"></i>
                </a>
            <?php
} ?>
        </li>
    </ul>
</div>