<nav id="pagination" aria-label="task list pagination">
    <ul class="pagination justify-content-end">
        <li class="page-item <?php if ( in_array($pages, [0,1]) || 1==$active) echo "disabled"; ?>">
            <a class="page-link" data-page="prev" href="/">Previous</a>
        </li>
        <?php if (1 <= $pages) {
            for ($i=1; $i<=$pages; $i++) {
                $activeClass = ($i == $active) ? 'active' : '';
        ?>
        <li class="page-item <?=$activeClass?>"><a class="page-link <?=$activeClass?>" data-page="<?=$i?>" href="/"><?=$i?></a></li>
        <?php }} ?>
        <li class="page-item <?php if ( in_array($pages, [0,1]) || $pages==$active) echo "disabled"; ?>">
            <a class="page-link" data-page="next" href="/">Next</a>
        </li>
    </ul>
</nav>