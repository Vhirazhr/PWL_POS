import { expect, test } from '@playwright/test';

test('Harus bisa login sebagai manager', async ({ page }) => {
  // 1. Buka halaman login
  await page.goto('http://127.0.0.1:8000/login');

  // 2. Isi username & password
  await page.fill('input[name="username"]', 'manager');
  await page.fill('input[name="password"]', '12345');

  // 3. Klik tombol login dan tunggu pindah halaman
  await Promise.all([
    page.waitForNavigation({ waitUntil: 'load' }),
    page.click('button[type="submit"]'),
  ]);

  // 4. Verifikasi login berhasil
  await expect(page.locator('text=Dashboard')).toBeVisible();
});
