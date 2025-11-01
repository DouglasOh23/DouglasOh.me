# Resume Website

This repository hosts a PHP-powered, single-page resume for quick review by recruiters and hiring teams. Update `resume-data.php` with your information and deploy the site anywhere that can serve PHP (XAMPP, shared hosting, Render, Fly, etc.).

## Getting Started

1. Edit `resume-data.php` and replace the placeholder data with your real experience.
2. Open the site locally (e.g. `http://localhost/DouglasOh.me/index.php`) using XAMPP or any PHP server.
3. Adjust copy or design in `index.php` and `styles.css` as needed.
4. Commit and deploy.

## Updating Your Resume Data

- Keep `resume-data.php` as the single source of truth for content.
- Arrays map directly to sections (experience, projects, education, awards, skills).
- Remove any sections you do not need by returning an empty array.
- Add or reorder list items to highlight your best work first.

## Print and ATS Tips

- Use the “Print / Save PDF” button to export an ATS-friendly PDF through your browser.
- Keep bullet points impact-focused with metrics and measurable outcomes.
- Ensure contact links stay current; obfuscate your email if you want to avoid scraping.

## Deployment Suggestions

- **GitHub Pages + GitHub Actions**: Build with `php -S` or export static HTML during CI and publish.
- **Vercel / Netlify / Render**: Drop the files into a PHP-ready environment or leverage serverless functions.
- **Traditional hosting**: Upload the repository to your PHP-compatible host via FTP/SFTP.

## Next Steps

- Swap placeholder data for your actual resume content.
- Add a custom domain and SSL certificate if publishing publicly.
- Consider adding light/dark themes or multilingual copies if helpful for recruiters.
