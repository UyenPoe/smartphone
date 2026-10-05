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
  await page.setViewport({ width: 1440, height: 1080 });

  // 1. Visit Flip 7 product page and screenshot the 8 quick specs rows (the user uploaded issue area)
  const flipUrl = 'http://localhost/smartphone/product/grade-a-new-seal-samsung-galaxy-z-flip-7-12gb-256gb-den-new-seal/';
  console.log(`Navigating to ${flipUrl}...`);
  await page.goto(flipUrl, { waitUntil: 'networkidle2' });
  await new Promise(r => setTimeout(r, 800));

  // Find the quick specs element and take an element screenshot
  const quickSpecs = await page.$('.space-y-2\\.5.p-4');
  if (quickSpecs) {
    await quickSpecs.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_contrast_quick_specs_focused.png') });
    console.log('Saved screenshot_contrast_quick_specs_focused.png');
  }

  // Full right column screenshot (Price, 8 quick specs, CTAs)
  const cols = await page.$$('.lg\\:col-span-6');
  if (cols && cols.length > 1) {
    await cols[1].screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_contrast_buybox.png') });
    console.log('Saved screenshot_contrast_buybox.png (right column)');
  }

  // Scroll to full specs table
  await page.evaluate(() => {
    const el = document.getElementById('fullSpecsSection');
    if (el) el.scrollIntoView({ behavior: 'instant', block: 'start' });
  });
  await new Promise(r => setTimeout(r, 600));
  await page.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_contrast_full_specs_table.png') });
  console.log('Saved screenshot_contrast_full_specs_table.png');

  // 2. Visit Kho Máy Cũ
  console.log('Navigating to Kho Máy Cũ...');
  await page.goto('http://localhost/smartphone/kho-may-cu/', { waitUntil: 'networkidle2' });
  await new Promise(r => setTimeout(r, 800));

  // Screenshot catalog cards
  const grid = await page.$('#catalog-grid');
  if (grid) {
    await grid.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_contrast_kho_may_cu_cards.png') });
    console.log('Saved screenshot_contrast_kho_may_cu_cards.png');
  }

  // Scroll to footer and take screenshot
  await page.evaluate(() => {
    window.scrollTo(0, document.body.scrollHeight);
  });
  await new Promise(r => setTimeout(r, 600));
  const footer = await page.$('footer[data-component="footer"]');
  if (footer) {
    await footer.screenshot({ path: path.join(ARTIFACT_DIR, 'screenshot_contrast_footer.png') });
    console.log('Saved screenshot_contrast_footer.png');
  }

  await browser.close();
  console.log('Contrast verification complete!');
}

main().catch(err => {
  console.error(err);
  process.exit(1);
});
