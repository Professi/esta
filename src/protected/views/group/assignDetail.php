<?php
/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock
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
/**
 * @var $assignedUser[user|user_id|group|group_id]
 */
?>

<tr>
    <td>
        <?= $assignedUser['user'] ?>
        <input type="hidden" name="user[]" class="group-user" value="<?= $assignedUser['user_id'] ?>">
    </td>
    <td>
        <?= $assignedUser['group'] ?>
        <input type="hidden" name="group[]" class="group-id" value="<?= $assignedUser['group_id'] ?>">
    </td>
    <td class='text-center'><i class="fi-x flag-relation-for-delete"></i></td>
</tr>