# WP Cycle Content
This is a custom plugin that will create a Custom Post Type in WordPress and then dynamically cycle through it's
archive page in a modal.

I've added in some basic animation and transitions, but would choose to leave the styling refinements to the
theme styles.

### Why?
Here are a few reasons why I wrote this plugin:
- Explore using `admin-ajax`.
- Create an accessible modal.
- Utilize ES6.
- Refrain from using jQuery.

### Starter Plugin
This plugin is built off of a littler starter plugin I've been working on.
You can find it here: https://github.com/efuller/wp-starter-plugin

### Try It!
1. Clone or download this repo into the plugins directly of a local WordPress install.
2. Activate the `wp-cycle-content-tutorial` plugin.
3. Add a few profiles. Be sure to add a post title, post content, featured image, and a job title via the post meta.
4. After adding some profiles, visit the `/profile` page.
5. Click on an article and watch the magic happen!

### Example
![](https://d.pr/i/Tv8XzU+)

### Props
[Jeffery Way](https://laracasts.com/) - For the dependency injection container idea.  
[bitsofcode](https://bitsofco.de/accessible-modal-dialog/) - Ideas on creating an accessible modal.
