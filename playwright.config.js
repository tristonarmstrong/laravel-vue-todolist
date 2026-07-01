import { defineConfig } from '@playwright/test';

const baseURL = process.env.APP_URL ?? 'http://127.0.0.1:8000';
const skipWebServer = !!process.env.PLAYWRIGHT_SKIP_WEB_SERVER;

export default defineConfig({
    testDir: './tests/e2e',
    fullyParallel: true,
    forbidOnly: !!process.env.CI,
    retries: process.env.CI ? 2 : 0,
    reporter: process.env.CI ? 'github' : 'list',
    use: {
        baseURL,
        trace: 'on-first-retry',
        viewport: { width: 1280, height: 720 },
    },
    webServer: skipWebServer
        ? undefined
        : {
            command: 'php artisan migrate --force && php artisan serve --host 127.0.0.1 --port 8000',
            url: baseURL,
            reuseExistingServer: !process.env.CI,
            timeout: 120000,
        },
});
