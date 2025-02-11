# Job Listings Plugin
A simple WordPress plugin that adds a custom post type for job listings, allowing administrators to manage job postings and display them using a shortcode.

🚀 Features
Creates a "Jobs" custom post type with fields for:
Job Title
Company Name
Location
Salary
Description
Admin Settings Page to set a default salary.
Shortcode [job_listings] to display job listings on any page.
Custom Meta Boxes for easy job data entry.
Fully follows WordPress coding standards.

📌 Installation
Download the plugin folder and upload it to /wp-content/plugins/.
Activate the plugin from WordPress Admin > Plugins.
Go to Jobs in the WordPress dashboard to add new job listings.
Use [job_listings] on any page to display job listings.

🛠 Usage
Adding a Job Listing:
Go to Jobs > Add New, enter details, and publish.
Displaying Jobs on a Page:
Add [job_listings] to any post or page.
Setting a Default Salary:
Go to Settings > Job Settings and set a default salary value.

📌 Customization
Modify the job_listings_shortcode() function in job-listings.php for custom layouts.
Adjust CSS for styling as needed.
🛠 Troubleshooting
Job Listings Not Showing?
Ensure jobs are published, and the shortcode is added to a page.
Flush permalinks: Go to Settings > Permalinks and click "Save Changes."

📄 License
This plugin is open-source and licensed under the GPL-2.0.