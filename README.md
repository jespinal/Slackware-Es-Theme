# Slackware-Es WordPress Theme

WordPress theme for the Spanish version of the Slackware Linux project's website. This theme mimics the look and feel of the official Slackware Linux project's website.

Feel free to put up your translation of the official project's website and contribute to the community :)

---

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Contributing](#contributing)
- [License](#license)

## Features
- Mimics the design of the official Slackware Linux website.
- Simple and lightweight.
- Easy to customize for translations and community contributions.
- **Smart sidebar navigation**: Posts can be associated with menu items via custom fields, enabling hierarchical content organization without cluttering the menu structure.

## Installation
1. Download the theme files.
2. Upload the theme folder to your WordPress installation under `wp-content/themes/`.
3. Activate the theme from the WordPress admin dashboard.
4. Configure your sidebar menu under **Appearance > Menus** and assign it to the "Sidebar Menu" location.

### Hierarchical Content with Custom Fields

This theme supports organizing posts under menu items without adding them directly to the menu. This is useful for creating documentation structures, tutorials, or any hierarchical content where individual posts belong to a parent section.

**How it works:**
1. Identify the ID of the page/post that appears in your sidebar menu (hover over it in the Pages list to see `post=123` in the URL).
2. When creating a post that conceptually belongs to that menu item, add a custom field:
   - **Name**: `parent_page_id`
   - **Value**: The ID of the parent page (e.g., `123`)
3. When visitors view that post, the sidebar will automatically highlight the parent section as active, showing proper visual indicators and separators.

**Example use case:**  
You have a "Installation Guide" page in your menu (ID: 474). You create multiple posts like "Step 1: Download", "Step 2: Create USB", etc. By adding `parent_page_id = 474` to each post, the sidebar will show "Installation Guide" as active when viewing any of those posts, even though they're not in the menu themselves.

## Contributing
Contributions are welcome! If you'd like to improve this theme, please:
1. Fork the repository.
2. Create a new branch for your changes.
3. Submit a pull request with a clear description of your updates.

## License
This theme is licensed under the GNU General Public License v2 (or later). See the `LICENSE` file for details.
