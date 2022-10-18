<?php

/**
 * @return string
 */
function na5ku_last_jobs()
{
    $valuta = get_option('mc_bg_valuta') == 'ru' ? 2 : 1;
    $id = uniqid('na5kuLastJobs_');
    $html = renderJSConst() . '
<div class="na5ku-last-jobs-div">
    <div class="last-works-desktop">
        <table class="na5ku-last-jobs">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Номер</th>
                        <th>Тема</th>
                        <th>Тип</th>
                    </tr>
                </thead>
                <tbody></tbody>
        </table>
    </div>
    <div class="last-works-mobile">
        <div class="na5ku-last-jobs-mobile reviews-slider-services owl-carousel owl-theme">
    
        </div>
    </div>
</div>';
    wp_enqueue_script('na5ku-last-jobs.js');
    wp_enqueue_style('na5ku-last-jobs.css');

    return $html;
}
