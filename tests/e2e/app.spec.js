import { expect, test } from '@playwright/test';

test('landing page links to the login screen', async ({ page }) => {
    await page.goto('/');

    await expect(page.getByRole('heading', { name: "You're not signed in" })).toBeVisible();
    await expect(page.getByRole('link', { name: 'Go To Log In' })).toBeVisible();

    await page.getByRole('link', { name: 'Go To Log In' }).click();

    await expect(page).toHaveURL(/\/login$/);
    await expect(page.getByRole('heading', { name: 'Go ahead and authenticate' })).toBeVisible();
    await expect(page.getByLabel('Email')).toBeVisible();
    await expect(page.getByLabel('Password')).toBeVisible();
});

test('login screen shows error message when incorrect credentials are provided', async ({ page }) => {
    await page.goto('/login');

    await page.getByLabel('Email').fill('test@example.com');
    await page.getByLabel('Password').fill('incorrect-password');
    await page.getByRole('button', { name: 'Login' }).click();

    await expect(page.getByText('The provided credentials do not match our records.')).toBeVisible();
});

test('login screen redirects to the dashboard when correct credentials are provided', async ({ page }) => {
    await page.goto('/login');

    await page.getByLabel('Email').fill('test@example.com');
    await page.getByLabel('Password').fill('password');
    await page.getByRole('button', { name: 'Login' }).click();

    await expect(page.getByRole('heading', { name: "You're not signed in" })).not.toBeVisible();
    await expect(page.getByText('Hi! Welcome')).toBeVisible();
})
