# Sparkle Haven – project page (PHP)

Proposed URL: `/projects/sparkle-haven-villa-east-hyderabad`

## Files
- `sparkle-haven-villa-east-hyderabad.php` – page template (layout only)
- `includes/content.php` – **all copy** from the content PDF; edit text here
- `includes/config.php` – URLs, contact link, image helper
- `includes/header.php`, `includes/footer.php` – main-site header/footer markup; theme CSS/JS loaded from jagathswapnahyd.com
- `assets/css/sparkle-haven.css`, `assets/js/sparkle-haven.js` – page styles/behaviour (all classes prefixed `sh-`)
- `.htaccess` – pretty URL rewrite (Apache/LiteSpeed)
- `router.php` + `assets/dev/` – local preview only (`php -S localhost:8000 router.php`); not needed in production

## Adding images / video later (no code changes)
Drop files into `assets/img/sparkle-haven/` named as below (.webp/.jpg/.jpeg/.png). Until then a labelled placeholder shows.

| File name | Used for |
|---|---|
| hero | hero background (or add `assets/video/sparkle-haven-hero.mp4` for video) |
| introduction | intro split, right side |
| highlights | left panel of Project Highlights |
| community-planning | Community Planning image |
| plan-east-ground, plan-east-first, plan-east-second | Haven East floor plans |
| plan-west-ground, plan-west-first, plan-west-second | Haven West floor plans |
| kala-vedika, jump-joy-zone, oxygen-fitness-zone, nirvana-garden, court-side-harmony | outdoor space cards |
| visit | background of closing CTA |

## Image sources (Google Drive "Havan_assets", converted to WebP ≤2000px)
hero ← VIEWS/EAST/East Morning · introduction ← VIEWS/WEST/West Night · highlights ← Club House D/N/wide angle day · community-planning ← Street Views 360/1 Entry Arch · plan-east-* ← Floor Plans/East Floor Plans · plan-west-* ← Floor Plans/West Floor Plans · kala-vedika, jump-joy-zone, oxygen-fitness-zone, nirvana-garden ← Amenities/(same names) · court-side-harmony ← Amenities/Country Side Harmony · visit ← Club House D/N/wide angle night.
Not yet used but available in the Drive: East/West interior renders (living, kitchen, home theatre, bedrooms), clubhouse interiors + pool/gym, night views, sports club.

## Hero video
`assets/video/sparkle-haven-hero.mp4` – the supplied "Feel Premium - Haven.mp4" (457 MB, 1080p) re-encoded to 1280×720 H.264 + AAC with fast-start (~27 MB). Autoplays muted and loops; the round button bottom-left toggles sound. Keep the original file as the master.
