#!/usr/bin/env node
/**
 * PhoneX - Component Synchronizer & Separator Script
 * Extracts, links shared CSS, and syncs components/header.html + components/footer.html
 * into all 46 pages cleanly with clear component boundaries.
 */

const fs = require('fs');
const path = require('path');

const ROOT_DIR = path.join(__dirname, '..');
const PAGES_DIR = path.join(ROOT_DIR, 'pages');
const HEADER_TPL = fs.readFileSync(path.join(ROOT_DIR, 'components', 'header.html'), 'utf-8');
const FOOTER_TPL = fs.readFileSync(path.join(ROOT_DIR, 'components', 'footer.html'), 'utf-8');

function walk(dir) {
  let results = [];
  const list = fs.readdirSync(dir);
  list.forEach(file => {
    const full = path.join(dir, file);
    const stat = fs.statSync(full);
    if (stat && stat.isDirectory()) {
      results = results.concat(walk(full));
    } else if (file === 'index.html') {
      results.push(full);
    }
  });
  return results;
}

const files = walk(PAGES_DIR);
console.log(`Đang đồng bộ Header/Footer dùng chung vào ${files.length} trang...`);

let updatedCount = 0;

files.forEach(file => {
  let content = fs.readFileSync(file, 'utf-8');
  const relDepth = '../../../'; // all pages are 3 levels deep: pages/<group>/<page>/index.html
  
  // 1. Replace inline <style id="px-responsive-hf"> with link to header-footer.css if present
  const cssLink = `<link href="${relDepth}assets/css/header-footer.css" rel="stylesheet"/>`;
  if (content.includes('<style id="px-responsive-hf">')) {
    content = content.replace(/<style id="px-responsive-hf">[\s\S]*?<\/style>/, cssLink);
  } else if (!content.includes('assets/css/header-footer.css')) {
    // Insert before </head>
    content = content.replace('</head>', `  ${cssLink}\n</head>`);
  }

  // 2. Prepare Header HTML with relative paths
  const headerHtml = `<!-- START: COMPONENT HEADER (Source: components/header.html) -->\n` +
    HEADER_TPL.replace(/\{\{ROOT\}\}/g, relDepth).trim() +
    `\n<!-- END: COMPONENT HEADER -->`;

  // 3. Prepare Footer HTML with relative paths
  const footerHtml = `<!-- START: COMPONENT FOOTER (Source: components/footer.html) -->\n` +
    FOOTER_TPL.replace(/\{\{ROOT\}\}/g, relDepth).trim() +
    `\n<!-- END: COMPONENT FOOTER -->`;

  // 4. Replace or wrap Header
  if (content.includes('<!-- START: COMPONENT HEADER')) {
    content = content.replace(
      /<!-- START: COMPONENT HEADER[\s\S]*?<!-- END: COMPONENT HEADER -->/,
      headerHtml
    );
  } else if (content.includes('<header class="pxH"')) {
    content = content.replace(
      /<header class="pxH"[\s\S]*?<\/header>/,
      headerHtml
    );
  }

  // 5. Replace or wrap Footer
  if (content.includes('<!-- START: COMPONENT FOOTER')) {
    content = content.replace(
      /<!-- START: COMPONENT FOOTER[\s\S]*?<!-- END: COMPONENT FOOTER -->/,
      footerHtml
    );
  } else if (content.includes('<footer class="pxF"')) {
    content = content.replace(
      /<footer class="pxF"[\s\S]*?<\/footer>/,
      footerHtml
    );
  }

  fs.writeFileSync(file, content, 'utf-8');
  updatedCount++;
});

console.log(` Hoàn tất tách và đồng bộ Header/Footer dùng chung cho ${updatedCount} trang thành công!`);
