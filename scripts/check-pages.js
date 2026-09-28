#!/usr/bin/env node
/**
 * PhoneX - Quality & Health Audit Script
 * Runs verification across all 46 pages.
 */

const fs = require('fs');
const path = require('path');

const PAGES_DIR = path.join(__dirname, '..', 'pages');
let totalErrors = 0;
let totalChecked = 0;

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

const htmlFiles = walk(PAGES_DIR);

console.log(`Kiểm tra chất lượng ${htmlFiles.length} trang HTML...`);

htmlFiles.forEach(file => {
  totalChecked++;
  const rel = path.relative(path.join(__dirname, '..'), file);
  const content = fs.readFileSync(file, 'utf-8');
  const issues = [];

  if (!content.includes('<!DOCTYPE html>') && !content.includes('<!doctype html>')) {
    issues.push('Thiếu <!DOCTYPE html>');
  }
  if (!/<html[^>]+lang="vi"/.test(content)) {
    issues.push('Thiếu thuộc tính lang="vi" trong <html>');
  }
  if (content.includes('\\1\\2')) {
    issues.push('Lỗi cú pháp regex \\1\\2');
  }
  if (content.includes('data-old-header') || content.includes('data-old-footer')) {
    issues.push('Còn chứa DOM rác (data-old-*)');
  }
  if (!/<title>.*?<\/title>/.test(content)) {
    issues.push('Thiếu thẻ <title>');
  }
  if (!content.includes('name="description"')) {
    issues.push('Thiếu thẻ <meta name="description">');
  }
  if (/alt="[^"]*(?:Primary color|Roundness|plusJakartaSans)/.test(content)) {
    issues.push('Thẻ alt chứa text prompt AI');
  }

  if (issues.length > 0) {
    totalErrors += issues.length;
    console.log(`❌ [${rel}]:`);
    issues.forEach(i => console.log(`   - ${i}`));
  }
});

if (totalErrors === 0) {
  console.log(`\n Tất cả ${totalChecked} trang đều đạt chuẩn chất lượng HTML, SEO & A11y!`);
  process.exit(0);
} else {
  console.log(`\n⚠️ Phát hiện ${totalErrors} lỗi cần xử lý.`);
  process.exit(1);
}
