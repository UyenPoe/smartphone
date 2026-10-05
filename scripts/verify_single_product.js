const puppeteer = require('puppeteer-core');
const path = require('path');

const ARTIFACT_DIR = '/Users/uyen/.gemini/antigravity/brain/b41f9105-3030-453d-8be2-4c5b6fb7f616';
const CHROME_PATH = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

async function main() {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });

  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 1000 });

  // 1. Visit Samsung Galaxy Z Flip 7 product page
  const flipUrl = 'http://localhost/smartphone/product/grade-a-new-seal-samsung-galaxy-z-flip-7-12gb-256gb-den-new-seal/';
  console.log(`Navigating to ${flipUrl}...`);
  await page.goto(flipUrl, { waitUntil: 'networkidle2' });
  await new Promise(r => setTimeout(r, 600));

  await page.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_product_flip7_top.png') });
  console.log('Saved screenshot_product_flip7_top.png');

  // Scroll down to specs and description
  await page.evaluate(() => {
    const el = document.getElementById('fullSpecsSection');
    if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
  });
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_product_flip7_specs.png') });
  console.log('Saved screenshot_product_flip7_specs.png');

  // 2. Visit Oppo Reno 15F product page
  const oppoUrl = 'http://localhost/smartphone/product/grade-a-new-seal-oppo-reno-15f-chinh-hang-moi-100/';
  console.log(`Navigating to ${oppoUrl}...`);
  await page.goto(oppoUrl, { waitUntil: 'networkidle2' });
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_product_oppo_reno15f.png') });
  console.log('Saved screenshot_product_oppo_reno15f.png');

  // 3. Test clicking from Kho Máy Cũ to a product page
  console.log('Navigating to Kho Máy Cũ to test product card navigation...');
  await page.goto('http://localhost/smartphone/kho-may-cu/', { waitUntil: 'networkidle2' });
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_kho_may_cu_catalog_linked.png') });
  console.log('Saved screenshot_kho_may_cu_catalog_linked.png');

  // 4. Test Mobile view of product page
  const mobilePage = await browser.newPage();
  await mobilePage.setViewport({ width: 390, height: 844, isMobile: true, hasTouch: true });
  await mobilePage.goto(flipUrl, { waitUntil: 'networkidle2' });
  await new Promise(r => setTimeout(r, 600));
  await mobilePage.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_product_mobile.png') });
  console.log('Saved screenshot_product_mobile.png');

  await browser.close();
  console.log('All verification screenshots captured successfully!');
}

main().catch(err => {
  console.error(err);
  process.exit(1);
});
