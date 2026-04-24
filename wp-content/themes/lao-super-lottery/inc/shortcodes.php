<?php
/**
 * Shortcodes.
 *
 * @package LaoSuperLottery
 */

if (! defined('ABSPATH')) {
    exit;
}

add_shortcode('lao_super_result', function (): string {
    $result = lao_super_fetch_latest_result();
    ob_start();
    ?>
    <section class="card" aria-label="Latest Lao Super result">
      <h2><?php echo esc_html($result['name']); ?></h2>
      <p><?php echo esc_html__('วันที่', 'lao-super-lottery') . ': ' . esc_html($result['date']); ?></p>
      <ul class="result-list">
        <li><strong>4 ตัว:</strong> <?php echo esc_html($result['results']['four_digits']); ?></li>
        <li><strong>3 ตัว:</strong> <?php echo esc_html(implode(', ', $result['results']['three_digits'])); ?></li>
        <li><strong>2 ตัว:</strong> <?php echo esc_html(implode(', ', $result['results']['two_digits'])); ?></li>
      </ul>
      <p class="description"><?php echo 'api' === $result['source'] ? esc_html__('ข้อมูลจาก API', 'lao-super-lottery') : esc_html__('กำลังแสดงข้อมูลสำรอง', 'lao-super-lottery'); ?></p>
    </section>
    <?php
    return (string) ob_get_clean();
});

add_shortcode('lao_super_history', function ($atts): string {
    $atts = shortcode_atts(array('days' => 7), $atts, 'lao_super_history');
    $days = max(1, min(31, absint($atts['days'])));
    $latest = lao_super_fetch_latest_result();

    ob_start();
    ?>
    <section class="card" aria-label="Lao Super history">
      <h3><?php echo esc_html(sprintf(__('ประวัติย้อนหลัง %d วัน', 'lao-super-lottery'), $days)); ?></h3>
      <p><?php esc_html_e('ตัวอย่างแสดงผลย้อนหลังควรเชื่อม API ประวัติแยก endpoint เพิ่มเติม', 'lao-super-lottery'); ?></p>
      <ul>
        <?php for ($i = 0; $i < $days; $i++) : ?>
          <li><?php echo esc_html($latest['date']); ?> — <?php echo esc_html($latest['results']['four_digits']); ?></li>
        <?php endfor; ?>
      </ul>
    </section>
    <?php
    return (string) ob_get_clean();
});

add_shortcode('lao_super_faq', function (): string {
    $faq_raw = lao_super_get_setting('content_faq_json', '');
    $faqs = json_decode($faq_raw, true);
    if (! is_array($faqs)) {
        $faqs = array();
    }

    ob_start();
    ?>
    <section class="card" aria-label="FAQ">
      <h3><?php esc_html_e('คำถามที่พบบ่อย', 'lao-super-lottery'); ?></h3>
      <?php if (empty($faqs)) : ?>
        <p><?php esc_html_e('ยังไม่มีข้อมูล FAQ กรุณาตั้งค่าผ่านผู้ดูแลระบบ', 'lao-super-lottery'); ?></p>
      <?php else : ?>
        <?php foreach ($faqs as $item) : ?>
          <div class="faq-item">
            <strong><?php echo esc_html($item['q'] ?? ''); ?></strong>
            <p><?php echo esc_html($item['a'] ?? ''); ?></p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </section>
    <?php
    return (string) ob_get_clean();
});
