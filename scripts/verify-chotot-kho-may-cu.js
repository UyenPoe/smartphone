const puppeteer = require('puppeteer-core');
const path = require('path');

const ARTIFACT_DIR = '/Users/uyen/.gemini/antigravity/brain/b41f9105-3030-453d-8be2-4c5b6fb7f616';
const CHROME_PATH = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 950 });

  console.log('1. Navigating to Kho Máy Cũ...');
  await page.goto('http://localhost/smartphone/kho-may-cu/', { waitUntil: 'networkidle2' });

  // Wait for product cards
  await page.waitForSelector('.phonex-phone-card');

  // Screenshot 1: Kho máy cũ overview with Chợ Tốt products and Hero badge
  await page.screenshot({
    path: path.join(ARTIFACT_DIR, 'kho_may_cu_chotot_overview.png'),
    fullPage: false
  });
  console.log('Saved kho_may_cu_chotot_overview.png');

  // Screenshot 2: Scroll down to product cards showing "Nguồn: Chợ Tốt" badge and links
  await page.evaluate(() => {
    window.scrollBy(0, 540);
  });
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({
    path: path.join(ARTIFACT_DIR, 'kho_may_cu_chotot_cards.png'),
    fullPage: false
  });
  console.log('Saved kho_may_cu_chotot_cards.png');

  // Screenshot 3: Filter specifically to "Nguồn: Chợ Tốt"
  console.log('2. Filtering by Nguồn: Chợ Tốt...');
  await page.select('#sourceFilterSelect', 'chotot');
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({
    path: path.join(ARTIFACT_DIR, 'kho_may_cu_chotot_filtered.png'),
    fullPage: false
  });
  console.log('Saved kho_may_cu_chotot_filtered.png');

  // Screenshot 4: Click to open modal for first Chợ Tốt product
  console.log('3. Opening modal for Chợ Tốt product...');
  const firstModalTrigger = await page.$('.open-phone-modal-trigger:not(.hidden)');
  if (firstModalTrigger) {
    await firstModalTrigger.click();
    await new Promise(r => setTimeout(r, 800));
    await page.screenshot({
      path: path.join(ARTIFACT_DIR, 'kho_may_cu_chotot_modal_inspection.png'),
      fullPage: false
    });
    console.log('Saved kho_may_cu_chotot_modal_inspection.png');

    // Close modal
    const closeBtn = await page.$('#closePhoneModalBtn');
    if (closeBtn) await closeBtn.click();
    await new Promise(r => setTimeout(r, 400));
  }

  // Screenshot 5: Navigate to a single product page for a Chợ Tốt phone
  console.log('4. Navigating to Single Product page...');
  const firstCardLink = await page.$('.phonex-phone-card:not(.hidden) a[href*="/product/"]');
  if (firstCardLink) {
    const href = await page.evaluate(el => el.href, firstCardLink);
    console.log('Visiting product page:', href);
    await page.goto(href, { waitUntil: 'networkidle2' });
    await page.screenshot({
      path: path.join(ARTIFACT_DIR, 'single_product_chotot_inspection.png'),
      fullPage: false
    });
    console.log('Saved single_product_chotot_inspection.png');
  }

  // Screenshot 6: WP-Admin Products list
  console.log('5. Visiting WP-Admin Products list...');
  await page.goto('http://localhost/smartphone/wp-login.php', { waitUntil: 'networkidle2' });
  await page.type('#user_login', 'admin');
  await page.type('#user_pass', 'admin123');
  await page.click('#wp-submit');
  await page.waitForNavigation({ waitUntil: 'networkidle2' });

  await page.goto('http://localhost/smartphone/wp-admin/edit.php?post_type=product', { waitUntil: 'networkidle2' });
  await page.screenshot({
    path: path.join(ARTIFACT_DIR, 'wp_admin_kho_may_cu_chotot_products.png'),
    fullPage: false
  });
  console.log('Saved wp_admin_kho_may_cu_chotot_products.png');

  await browser.close();
  console.log('Verification completed successfully!');
})();
