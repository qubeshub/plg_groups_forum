<?php
/**
 * HUBzero CMS
 *
 * Copyright 2005-2015 HUBzero Foundation, LLC.
 *
 * This file is part of: The HUBzero(R) Platform for Scientific Collaboration
 *
 * The HUBzero(R) Platform for Scientific Collaboration (HUBzero) is free
 * software: you can redistribute it and/or modify it under the terms of
 * the GNU Lesser General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * HUBzero is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * HUBzero is a registered trademark of Purdue University.
 *
 * @package   hubzero-cms
 * @author    Shawn Rice <zooley@purdue.edu>
 * @copyright Copyright 2005-2015 HUBzero Foundation, LLC.
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPLv3
 */

// No direct access
defined('_HZEXEC_') or die();

$base = 'index.php?option=com_groups&cn=' . $this->group->get('cn') . '&active=forum';

$this->css()
     ->js();
?>

<?php if ($this->getError()) { ?>
	<p class="error"><?php echo $this->getError(); ?></p>
<?php } ?>
<?php if ($this->message) { ?>
	<p class="passed"><?php echo $this->message; ?></p>
<?php } ?>
	<form action="<?php echo Route::url($base . '&action=savesettings'); ?>" method="post" id="hubForm" class="full">
		<fieldset class="settings">
			<legend><?php echo Lang::txt('PLG_GROUPS_FORUM_SETTINGS_THREADS'); ?></legend>

			<label for="param-threading">
				<?php echo Lang::txt('PLG_GROUPS_FORUM_SETTINGS_THREADING'); ?>
				<select name="params[threading]" id="param-threading">
					<option value="list"<?php if ($this->config->get('threading', 'list') == 'list') { echo ' selected="selected"'; }?>><?php echo Lang::txt('PLG_GROUPS_FORUM_SETTINGS_LIST'); ?></option>
					<option value="tree"<?php if ($this->config->get('threading', 'list') == 'tree') { echo ' selected="selected"'; }?>><?php echo Lang::txt('PLG_GROUPS_FORUM_SETTINGS_TREE'); ?></option>
				</select>
				<span class="hint"><?php echo Lang::txt('PLG_GROUPS_FORUM_SETTINGS_THREADING_HINT'); ?>
			</label>

			<label for="param-threading_depth">
				<?php echo Lang::txt('PLG_GROUPS_FORUM_SETTINGS_THREADING_DEPTH'); ?>
				<input type="text" name="params[threading_depth]" id="param-threading_depth" value="<?php echo $this->config->get('threading_depth', 3); ?>" />
				<span class="hint"><?php echo Lang::txt('PLG_GROUPS_FORUM_SETTINGS_THREADING_DEPTH_HINT'); ?></span>
			</label>

			<input type="hidden" name="settings[id]" value="<?php echo $this->settings->id; ?>" />
			<input type="hidden" name="settings[object_id]" value="<?php echo $this->group->get('gidNumber'); ?>" />
			<input type="hidden" name="settings[folder]" value="groups" />
			<input type="hidden" name="settings[element]" value="forum" />
		</fieldset>
		<div class="clear"></div>

		<input type="hidden" name="cn" value="<?php echo $this->group->get('cn'); ?>" />
		<input type="hidden" name="process" value="1" />
		<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
		<input type="hidden" name="active" value="forum" />
		<input type="hidden" name="action" value="savesettings" />

		<?php echo Html::input('token'); ?>

		<p class="submit">
			<input class="btn btn-success" type="submit" value="<?php echo Lang::txt('PLG_GROUPS_FORUM_SAVE'); ?>" />

			<a class="btn btn-secondary" href="<?php echo Route::url($base); ?>">
				<?php echo Lang::txt('PLG_GROUPS_FORUM_CANCEL'); ?>
			</a>
		</p>
	</form>
