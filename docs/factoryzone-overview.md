# FactoryZone – MVP System Overview (Tenant = Factory)

## 1. Product Summary

**Product Name (temporary)**  
FactoryZone – Multi-tenant SaaS platform for factories inside industrial / development zones in Jordan.

**Core Idea**  
- Each **factory** is a **tenant**.  
- Each tenant gets:
  - Its own **back-office** (manage profile, products, orders, etc.).
  - Its own **public subdomain storefront** (e.g., `acme.factoryzone.com`).  
- There is also a **central marketplace** (main domain) that lists selected products from all factories.

---

## 2. Tenancy Model

- **Tenant = Factory**
  - One factory = one tenant account.
  - Factory owner (or manager) signs up and creates their factory workspace.
- **Subdomains**
  - Back-office + storefront on subdomain, for example:
    - `acme.factoryzone.com`
    - `najahplastics.factoryzone.com`
- **Central Marketplace**
  - `www.factoryzone.com` (or main domain) shows:
    - All participating factories (directory)
    - Public products that factories choose to publish

> Note: Zone / Industrial Area will be stored as attributes on the factory (e.g., "Jordan – Sahab Industrial Zone"), not as tenants.

---

## 3. Target Customers & Users

**Who pays (customers)**  
- Individual factories (subscription per factory / per feature / per seats).
- Optionally: industrial zone authorities can sponsor or bulk pay for factories in their zone (future).

**Main user roles**

- **Factory Owner / Factory Admin (Tenant Admin)**
  - Manages factory profile, team users, product catalog, orders/requests, storefront settings.
- **Factory Staff**
  - Limited access (manage products, handle orders/requests).
- **Marketplace Visitor (Buyer)**
  - Public user browsing the marketplace or a specific factory subdomain.
  - Can view products and create inquiries/orders depending on MVP scope.
- **Platform Super Admin**
  - Manages tenants (factories), billing, global settings, and moderation.
- **Zone Manager (optional, future)**
  - View factories and activity within their specific industrial zone.

---

## 4. Problem Statement

From the factory perspective:
- Many factories do not have a proper online presence or e-commerce capability.
- Each factory struggles alone to show its products, share specs, and receive structured requests/orders.
- Communication is fragmented (WhatsApp, random PDFs, phone calls).

From the marketplace / ecosystem perspective:
- Buyers cannot easily discover factories inside a specific industrial zone or category.
- No unified marketplace that connects factories with buyers while allowing each factory to keep its own brand and space.

---

## 5. Core Value (MVP)

For factories:
- Quick onboarding to a **ready SaaS**: factory gets an online catalog + mini-storefront on its own subdomain.
- Central place to manage products, documents, and incoming requests/orders.
- No need to build a custom website or marketplace from scratch.

For buyers:
- One marketplace to discover factories by:
  - Category / industry
  - Industrial zone
  - Product type

For the platform owner:
- Recurring SaaS revenue from factories.
- Data about factories, products, and activity inside industrial zones.

---

## 6. MVP Features (Version 1 Only)

### 6.1 Tenant/Fatory Onboarding & Workspace

- Self-registration for factories:
  - Basic data: factory name, legal name, industrial zone, country, city.
  - Contact person: name, phone, email.
- Approval flow (optional for MVP): super admin can approve/reject tenants.
- Tenant-specific settings:
  - Logo, colors (basic theming)
  - Subdomain slug (e.g., `acme`)
  - Preferred languages (Arabic / English)

### 6.2 Factory Profile & Catalog (Back-Office)

- Factory profile page fields:
  - Description, industries, capabilities, certifications (optional)
  - Location (zone, city), Google Maps link (future)
- Product catalog management:
  - Categories (e.g., Plastics, Food, Textiles)
  - Products with:
    - Name, description
    - Photos
    - Basic attributes (SKU, dimensions, material, etc. depending on industry)
    - Price or “Price on request”
    - Publish/unpublish flag (controls visibility on marketplace)

### 6.3 Public Storefront per Factory (Subdomain)

- Public storefront at `{factory_slug}.factoryzone.com`:
  - Factory profile (about, location, contact info).
  - Product listing with filters/search.
  - Product detail page.
- Contact / inquiry form:
  - Buyer can send an inquiry (product, quantity, requirements).
  - Inquiry stored in the tenant workspace and optionally sent by email.

### 6.4 Central Marketplace (Main Domain)

- Public directory of factories:
  - Search by name, industry, industrial zone.
- Public product catalog (cross-tenant):
  - List of products from all factories that are marked as “publish to marketplace”.
  - Filters: category, zone, maybe price range (if used).
- Product detail page:
  - Shows supplier (factory), product info, and a button:
    - “Contact supplier” or “Request quote” (depending on MVP).
- Simple flows for inquiries:
  - Inquiry is linked to a specific product + factory.
  - Factory sees inquiries in its tenant workspace.

### 6.5 Basic Orders / Requests (MVP Level)

- MVP option (simpler): **Request for Quote (RFQ) flow**
  - Buyer fills RFQ form for a product.
  - Factory receives it and can respond offline (email/phone) for now.
- Future:
  - Full cart + checkout + payment integration.

### 6.6 Platform Admin Panel (Super Admin)

- View/manage factories (tenants):
  - Approve / suspend.
  - See basic usage and number of products.
- Manage marketplace categories and tags.
- Basic reporting:
  - Number of active factories.
  - Number of published products.
  - Number of inquiries per period.

---

## 7. Zones / Industrial Areas

- Each factory belongs to a **Zone** (industrial area), e.g.:
  - “Al Hassan Industrial Estate”
  - “Al Hussein Bin Abdullah II Industrial City”
- Zones stored as reference data:
  - Name, region, city, optional notes.
- Used for:
  - Filtering factories and products in the marketplace.
  - Future zone dashboards (not required in MVP).

---

## 8. External Systems / Integrations (MVP Scope)

Short term (MVP):
- Basic email (SMTP) for notifications (account activation, inquiries).
- Optional SMS provider (Jordan) later for critical notifications.

Future:
- Payment gateway integration (e.g., MyFatoorah) for full e-commerce.
- Map integration for factory locations.
- Integration with external ERP/Inventory systems for advanced factories.

---

## 9. Constraints & Architecture Notes

- Region: Jordan first; design general enough to support other countries later.
- Languages: Arabic + English (i18n ready from the beginning).
- Platform: Web app (responsive, desktop + tablet; mobile-friendly).
- Architecture:
  - Multi-tenant SaaS where **each tenant = one factory**.
  - Public marketplace running on the main domain with read access to published products across tenants.
- Security:
  - RBAC per tenant (owner, staff).
  - Strong separation between tenants (factories cannot see each other’s back-office data).
  - Marketplace only sees data explicitly marked as public/published.
