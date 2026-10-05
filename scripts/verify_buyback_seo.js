const puppeteer = require('puppeteer-core');
const CHROME_PATH = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const ARTIFACT_DIR = '/Users/uyen/.gemini/antigravity/brain/b41f9105-3030-453d-8be2-4c5b6fb7f616';

(async () => {
  const browser = await puppeteer.launch({
    executablePath: CHROME_PATH,
    headless: 'new',
    args: ['--no-sandbox', '--disable-setuid-sandbox']
  });
  const page = await browser.newPage();
  await page.setViewport({ width: 1440, height: 900 });

  console.log('1. Navigating to Bảng Giá Thu Mua (/bang-gia-thu-mua/)...');
  await page.goto('http://localhost/smartphone/bang-gia-thu-mua/', { waitUntil: 'networkidle2' });

  // Wait for product cards
  await page.waitForSelector('.phonex-phone-card');

  // Check that product cards rendered with crawlable links
  const firstCard = await page.$('.phonex-phone-card');
  const firstCardTitleEl = await firstCard.$('h3.px-ds-prod-title a');
  const firstCardUrl = await page.evaluate(el => el.href, firstCardTitleEl);
  const firstCardName = await page.evaluate(el => el.textContent, firstCardTitleEl);
  console.log(`First card: "${firstCardName.trim()}" -> URL: ${firstCardUrl}`);

  // Take screenshot of pricing catalog
  await page.screenshot({ path: `${ARTIFACT_DIR}/seo_pricing_table_with_links.png` });

  // Click on "Xem 5 Loại" on the first card
  console.log('2. Clicking "Xem 5 Loại" button on first card...');
  const firstPopupBtn = await page.$('.phonex-phone-card button');
  await firstPopupBtn.click();
  await new Promise(r => setTimeout(r, 600));

  // Check detail link inside modal
  const modalDetailLinkEl = await page.$('#pxPopupDetailLink');
  const modalDetailLink = await page.evaluate(el => el.href, modalDetailLinkEl);
  console.log(`Modal detail link: ${modalDetailLink}`);

  await page.screenshot({ path: `${ARTIFACT_DIR}/seo_modal_with_detail_link.png` });

  // Close modal
  const closeBtn = await page.$('#pxConditionModal button');
  if (closeBtn) await closeBtn.click();
  await new Promise(r => setTimeout(r, 300));

  // Navigate directly to the model page
  console.log(`3. Navigating to model page: ${firstCardUrl}...`);
  await page.goto(firstCardUrl, { waitUntil: 'networkidle2' });

  const title = await page.title();
  console.log(`Model Page Title: "${title}"`);

  // Check H1 and sections
  const h1El = await page.$('h1');
  const h1 = h1El ? await page.evaluate(el => el.textContent, h1El) : '';
  console.log(`Model H1: "${h1.trim()}"`);

  const hasSpecs = (await page.$('#thong-so-ky-thuat')) !== null;
  console.log(`Has Specs Section: ${hasSpecs ? 'YES' : 'NO'}`);

  const faqCount = await page.$$eval('#faqAccordion details', els => els.length);
  console.log(`FAQ questions count: ${faqCount}`);

  // Take screenshot of full model SEO page
  await page.screenshot({ path: `${ARTIFACT_DIR}/seo_model_buyback_landing_page.png` });

  // Scroll down to specs section
  if (hasSpecs) {
    await page.evaluate(() => {
      document.getElementById('thong-so-ky-thuat').scrollIntoView();
    });
    await new Promise(r => setTimeout(r, 400));
    await page.screenshot({ path: `${ARTIFACT_DIR}/seo_model_specs_section.png` });
  }

  // Scroll down to FAQ and standards section
  await page.evaluate(() => {
    window.scrollBy(0, 1000);
  });
  await new Promise(r => setTimeout(r, 400));
  await page.screenshot({ path: `${ARTIFACT_DIR}/seo_model_faq_and_tradein_section.png` });

  console.log('SUCCESS! All tests and screenshots completed.');
  await browser.close();
})();
