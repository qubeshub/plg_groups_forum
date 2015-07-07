<?php
/**
 * HUBzero CMS
 *
 * Copyright 2005-2015 Purdue University. All rights reserved.
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
 * @copyright Copyright 2005-2015 Purdue University. All rights reserved.
 * @license   http://www.gnu.org/licenses/lgpl-3.0.html LGPLv3
 */

defined('_HZEXEC_') or die();

$base = 'index.php?option=' . $this->option . '&cn=' . $this->group->get('cn') . '&active=forum&scope=' . $this->filters['section'] . '/' . $this->filters['category'];

if (!function_exists('sortDir'))
{
	function sortDir($filters, $current, $dir='DESC')
	{
		if ($filters['sortby'] == $current && $filters['sort_Dir'] == $dir)
		{
			$dir = ($dir == 'ASC' ? 'DESC' : 'ASC');
		}
		return strtolower($dir);
	}
}

$this->css()
     ->js();
?>

<ul id="page_options">
	<li>
		<a class="icon-folder categories btn" href="<?php echo Route::url('index.php?option=' . $this->option . '&cn=' . $this->group->get('cn') . '&active=forum'); ?>">
			<?php echo Lang::txt('PLG_GROUPS_FORUM_ALL_CATEGORIES'); ?>
		</a>
	</li>
</ul>

<section class="main section">
	<?php foreach ($this->notifications as $notification) { ?>
		<p class="<?php echo $notification['type']; ?>"><?php echo $this->escape($notification['message']); ?></p>
	<?php } ?>

	<form action="<?php echo Route::url('index.php?option=' . $this->option . '&cn=' . $this->group->get('cn') . '&active=forum'); ?>" method="get">
		<div class="container data-entry">
			<input class="entry-search-submit" type="submit" value="<?php echo Lang::txt('PLG_GROUPS_FORUM_SEARCH'); ?>" />
			<fieldset class="entry-search">
				<legend><?php echo Lang::txt('PLG_GROUPS_FORUM_SEARCH_LEGEND'); ?></legend>
				<label for="entry-search-field"><?php echo Lang::txt('PLG_GROUPS_FORUM_SEARCH_LABEL'); ?></label>
				<input type="text" name="q" id="entry-search-field" value="<?php echo $this->escape($this->filters['search']); ?>" placeholder="<?php echo Lang::txt('PLG_GROUPS_FORUM_SEARCH_PLACEHOLDER'); ?>" />
				<!--
				<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
				<input type="hidden" name="cn" value="<?php echo $this->escape($this->group->get('cn')); ?>" />
				<input type="hidden" name="active" value="forum" />
				<input type="hidden" name="action" value="search" />
				-->
			</fieldset>
		</div><!-- / .container -->

		<?php if ($this->category->get('closed')) { ?>
			<p class="warning">
				<?php echo Lang::txt('PLG_GROUPS_FORUM_CATEGORY_CLOSED'); ?>
			</p>
		<?php } ?>

		<div class="container">
			<ul class="entries-menu order-options">
				<li>
					<a class="<?php echo ($this->filters['sortby'] == 'created' ? 'active ' . strtolower($this->filters['sort_Dir']) : sortDir($this->filters, 'created')); ?>" href="<?php echo Route::url($base . '&sortby=created&sortdir=' . sortDir($this->filters, 'created')); ?>" title="<?php echo Lang::txt('PLG_GROUPS_FORUM_SORT_BY_CREATED'); ?>">
						<?php echo Lang::txt('PLG_GROUPS_FORUM_SORT_CREATED'); ?>
					</a>
				</li>
				<li>
					<a class="<?php echo ($this->filters['sortby'] == 'activity' ? 'active ' . strtolower($this->filters['sort_Dir']) : sortDir($this->filters, 'activity')); ?>" href="<?php echo Route::url($base . '&sortby=activity&sortdir=' . sortDir($this->filters, 'activity')); ?>" title="<?php echo Lang::txt('PLG_GROUPS_FORUM_SORT_BY_ACTIVITY'); ?>">
						<?php echo Lang::txt('PLG_GROUPS_FORUM_SORT_ACTIVITY'); ?>
					</a>
				</li>
				<li>
					<a class="<?php echo ($this->filters['sortby'] == 'replies' ? 'active ' . strtolower($this->filters['sort_Dir']) : sortDir($this->filters, 'replies')); ?>" href="<?php echo Route::url($base . '&sortby=replies&sortdir=' . sortDir($this->filters, 'replies')); ?>" title="<?php echo Lang::txt('PLG_GROUPS_FORUM_SORT_BY_NUM_POSTS'); ?>">
						<?php echo Lang::txt('PLG_GROUPS_FORUM_SORT_NUM_POSTS'); ?>
					</a>
				</li>
				<li>
					<a class="<?php echo ($this->filters['sortby'] == 'title' ? 'active ' . strtolower($this->filters['sort_Dir']) : sortDir($this->filters, 'title', 'ASC')); ?>" href="<?php echo Route::url($base . '&sortby=title&sortdir=' . sortDir($this->filters, 'title', 'ASC')); ?>" title="<?php echo Lang::txt('PLG_GROUPS_FORUM_SORT_BY_TITLE'); ?>">
						<?php echo Lang::txt('PLG_GROUPS_FORUM_SORT_TITLE'); ?>
					</a>
				</li>
			</ul>

			<table class="entries">
				<caption>
					<?php
						if ($this->filters['search']) {
							if ($this->category->exists()) {
								echo Lang::txt('PLG_GROUPS_FORUM_SEARCH_FOR_IN', $this->escape($this->filters['search']), $this->escape(stripslashes($this->category->get('title'))));
							} else {
								echo Lang::txt('PLG_GROUPS_FORUM_SEARCH_FOR', $this->escape($this->filters['search']));
							}
						} else {
							if ($this->category->exists()) {
								echo Lang::txt('PLG_GROUPS_FORUM_DISCUSSIONS_IN', $this->escape(stripslashes($this->category->get('title'))));
							} else {
								echo Lang::txt('PLG_GROUPS_FORUM_DISCUSSIONS');
							}
						}
					?>
				</caption>
			<?php if (!$this->category->get('closed') && $this->config->get('access-create-thread')) { ?>
				<tfoot>
					<tr>
						<td colspan="<?php echo ($this->config->get('access-delete-thread') || $this->config->get('access-edit-thread')) ? '5' : '4'; ?>">
							<a class="icon-add add btn" href="<?php echo Route::url($base . '/new'); ?>">
								<?php echo Lang::txt('PLG_GROUPS_FORUM_NEW_DISCUSSION'); ?>
							</a>
						</td>
					</tr>
				</tfoot>
			<?php } ?>
				<tbody>
			<?php
			if ($this->category->threads('list', $this->filters)->total() > 0) {
				foreach ($this->category->threads() as $row)
				{
					$name = Lang::txt('PLG_GROUPS_FORUM_ANONYMOUS');
					if (!$row->get('anonymous'))
					{
						$name = $this->escape(stripslashes($row->creator('name')));
						$name = ($row->creator('public') ? '<a href="' . Route::url($row->creator()->getLink()) . '">' . $name . '</a>' : $name);
					}
					$cls = array();
					if ($row->get('closed'))
					{
						$cls[] = 'closed';
					}
					if ($row->get('sticky'))
					{
						$cls[] = 'sticky';
					}
					?>
					<tr<?php if (count($cls) > 0) { echo ' class="' . implode(' ', $cls) . '"'; } ?>>
						<th>
							<span class="entry-id"><?php echo $this->escape($row->get('id')); ?></span>
						</th>
						<td>
							<a class="entry-title" href="<?php echo Route::url($base . '/' . $row->get('id')); ?>">
								<span><?php echo $this->escape(stripslashes($row->get('title'))); ?></span>
							</a>
							<span class="entry-details">
								<span class="entry-date">
									<time datetime="<?php echo $row->created(); ?>"><?php echo $row->created('date'); ?></time>
								</span>
								<?php echo Lang::txt('PLG_GROUPS_FORUM_BY_USER', '<span class="entry-author">' . $name . '</span>'); ?>
							</span>
						</td>
						<td>
							<span><?php echo ($row->posts('count')); ?></span>
							<span class="entry-details">
								<?php echo Lang::txt('PLG_GROUPS_FORUM_COMMENTS'); ?>
							</span>
						</td>
						<td>
							<span><?php echo Lang::txt('PLG_GROUPS_FORUM_LAST_POST'); ?></span>
							<span class="entry-details">
						<?php
							$lastpost = $row->lastActivity();
							if ($lastpost->exists())
							{
									$lname = Lang::txt('PLG_GROUPS_FORUM_ANONYMOUS');
									if (!$lastpost->get('anonymous'))
									{
										$lname = $this->escape(stripslashes($lastpost->creator('name')));
										$lname = ($lastpost->creator('public') ? '<a href="' . Route::url($lastpost->creator()->getLink()) . '">' . $lname . '</a>' : $lname);
									}
								?>
								<span class="entry-date">
									<time datetime="<?php echo $lastpost->created(); ?>"><?php echo $lastpost->created('date'); ?></time>
								</span>
								<?php echo Lang::txt('PLG_GROUPS_FORUM_BY_USER', '<span class="entry-author">' . $lname . '</span>'); ?>
						<?php } else { ?>
								<?php echo Lang::txt('PLG_GROUPS_FORUM_NONE'); ?>
						<?php } ?>
							</span>
						</td>
					<?php if ($this->config->get('access-delete-thread') || $this->config->get('access-edit-thread') || User::get('id') == $row->get('created_by')) { ?>
						<td class="entry-options">
							<?php if ($row->get('created_by') == User::get('id') || $this->config->get('access-edit-thread')) { ?>
								<a class="icon-edit edit" href="<?php echo Route::url($base . '/' . $row->get('id') . '/edit'); ?>">
									<?php echo Lang::txt('PLG_GROUPS_FORUM_EDIT'); ?>
								</a>
							<?php } ?>
							<?php if ($this->config->get('access-delete-thread')) { ?>
								<a class="icon-delete delete" href="<?php echo Route::url($base . '/' . $row->get('id') . '/delete'); ?>">
									<?php echo Lang::txt('PLG_GROUPS_FORUM_DELETE'); ?>
								</a>
							<?php } ?>
						</td>
					<?php } ?>
					</tr>
				<?php } ?>
			<?php } else { ?>
					<tr>
						<td><?php echo Lang::txt('PLG_GROUPS_FORUM_CATEGORY_EMPTY'); ?></td>
					</tr>
			<?php } ?>
				</tbody>
			</table>

			<?php
			$pageNav = $this->pagination(
				$this->category->threads('count', $this->filters),
				$this->filters['start'],
				$this->filters['limit']
			);
			$pageNav->setAdditionalUrlParam('cn', $this->group->get('cn'));
			$pageNav->setAdditionalUrlParam('active', 'forum');
			$pageNav->setAdditionalUrlParam('scope', $this->filters['section'] . '/' . $this->filters['category']);
			echo $pageNav->render();
			?>
		</div><!-- / .container -->
	</form>
</section><!-- /.main -->
