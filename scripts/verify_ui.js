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

  // 1. Visit Kho Máy Cũ & Hover dropdown
  console.log('Navigating to http://localhost/smartphone/kho-may-cu/...');
  await page.goto('http://localhost/smartphone/kho-may-cu/', { waitUntil: 'networkidle2' });

  // Show dropdown
  await page.evaluate(() => {
    const el = document.getElementById('pxUsedPhonesDropdown');
    if (el) el.classList.remove('hidden');
  });
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_kho_may_cu_dropdown_brands.png') });
  console.log('Saved screenshot_kho_may_cu_dropdown_brands.png');

  // Hide dropdown
  await page.evaluate(() => {
    const el = document.getElementById('pxUsedPhonesDropdown');
    if (el) el.classList.add('hidden');
  });

  // 2. Click on a product card to open Showroom Modal
  console.log('Opening phone showroom modal...');
  const cardTrigger = await page.$('.open-phone-modal-trigger');
  if (cardTrigger) {
    await cardTrigger.click();
    await new Promise(r => setTimeout(r, 800));
    await page.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_kho_may_cu_modal_device.png') });
    console.log('Saved screenshot_kho_may_cu_modal_device.png');
  }

  // 3. Mobile responsive view
  console.log('Testing mobile responsive layout...');
  const mobilePage = await browser.newPage();
  await mobilePage.setViewport({ width: 390, height: 844, isMobile: true, hasTouch: true });
  await mobilePage.goto('http://localhost/smartphone/kho-may-cu/?cat=oppo', { waitUntil: 'networkidle2' });
  await new Promise(r => setTimeout(r, 600));
  await mobilePage.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_kho_may_cu_mobile_brands.png') });
  console.log('Saved screenshot_kho_may_cu_mobile_brands.png');

  await browser.close();
  console.log('All UI verification screenshots generated successfully!');
}

main().catch(err => {
  console.error(err);
  process.exit(1);
});
