<?php

namespace Comments;

/**
 * Class Wrapper
 *
 * This class has wrapper functions for normal comment tree view.
 *
 * @package Comments
 * @author Constantine M. Lapkin <constlapkin@gmail.com>
 */
class Wrapper
{
    /**
     * The tree function rebuilds the data array under the tree structure
     * based on the parameter parent_id.
     *
     * @param array $data
     * @return array
     */
    public static function tree(array $data)
    {
        $comments = array();
        foreach ($data as $row) {
            $row['childs'] = array();
            $comments[$row['id']] = $row;
        }

        foreach ($comments as $k => &$v) {
            if ($v['parent_id'] != 0) {
                $comments[$v['parent_id']]['childs'][] =& $v;
            }
        }
        unset($v);

        foreach ($comments as $k => $v) {
            if ($v['parent_id'] != 0) {
                unset($comments[$k]);
            }
        }
        return $comments;
    }

    /**
     * A recursive function is responsible for printing a nested array with a form under each comment.
     *
     * @param array $comments
     * @param int $level
     */
    public static function printComment(array $comments, $level = 0) {
        foreach ($comments as $comment):?>
            <div id="con-<?=$comment['id']?>">
                <?=str_repeat(' - ', $level + 1)?>
                <?=$comment['id']?>
                <br>
                <?=str_repeat(' - ', $level + 1)?>
                <?=$comment['text']?>
                <br>
                <form id="form_<?=$comment['id']?>">
                    <textarea name="text_comment" form="form_<?=$comment['id']?>"></textarea>
                    <input name="id_comment" type="hidden" value="<?=$comment['id']?>">
                    <input name="level_comment" type="hidden" value="<?=$level?>">
                    <button type="submit" class="formclass" type="button">Отправить</button>
                </form>
            </div>
            <?php
            if (!empty($comment['childs'])) {
                Wrapper::printComment($comment['childs'], $level + 1);
            }
        endforeach;
    }
}