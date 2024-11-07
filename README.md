# <img src="https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw04g05/assets/131660816/f371bb97-24a3-43c9-8c39-70de553eb0bb" alt="logo" width="50" height="30" /> Thrift Trove

## Group ltw04g05

- Bruno Fortes (up202209730) 33.3%
- Ângelo Oliveira (up202207798) 33.3%
- José Costa (up202207871) 33.3%

## Install Instructions
    git clone https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw04g05.git
    git checkout final-delivery-v1
    sqlite database/database.db < database/database.sql
    php -S localhost:9000

## External Libraries and APIs

We have used the following external libraries and APIs:

- Font Awesome
- Google Maps
- LocationIQ
- DOMPurify 

## Screenshots

### Homepage
![Screenshot from 2024-05-19 14-01-58](https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw04g05/assets/131660816/4205ef76-4ebd-46bd-a499-b3d64e9c5acf)

### Profile
![Screenshot from 2024-05-19 14-02-40](https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw04g05/assets/131660816/98587d30-59cf-4aa2-b33a-efdb896b917c)

### Item Page
![Screenshot from 2024-05-19 14-03-10](https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw04g05/assets/131660816/c0251391-c2fc-487f-bf2a-bfd07dc6288d)

### Checkout
![Screenshot from 2024-05-19 14-03-29](https://github.com/FEUP-LTW-2024/ltw-project-2024-ltw04g05/assets/131660816/4716fc98-8e4a-402f-aa2b-931ea6896942)

## Implemented Features

**General**:

- [X] Register a new account.
- [X] Log in and out.
- [X] Edit their profile, including their name, username, password, and email.

**Sellers**:

- [X] List new items, providing details such as category, brand, model, size, and condition, along with images.
- [X] Track and manage their listed items.
- [X] Respond to inquiries from buyers regarding their items and add further information if needed.
- [X] Print shipping forms for items that have been sold.

**Buyers**:

- [X] Browse items using filters like category, price, and condition.
- [X] Engage with sellers to ask questions or negotiate prices.
- [X] Add items to a wishlist or shopping cart.
- [X] Proceed to checkout with their shopping cart (simulate payment process).

**Admins**:

- [X] Elevate a user to admin status.
- [X] Introduce new item categories, sizes, conditions, and other pertinent entities.
- [X] Oversee and ensure the smooth operation of the entire system.

**Security**:
We have been careful with the following security aspects:

- [X] **SQL injection**
- [X] **Cross-Site Scripting (XSS)**
- [X] **Cross-Site Request Forgery (CSRF)**

**Password Storage Mechanism**: sha1

**Aditional Requirements**:

- [X] **Rating and Review System**
- [ ] **Promotional Features**
- [ ] **Analytics Dashboard**
- [ ] **Multi-Currency Support**
- [ ] **Item Swapping**
- [ ] **API Integration**
- [ ] **Dynamic Promotions**
- [ ] **User Preferences**
- [X] **Shipping Costs**
- [X] **Real-Time Messaging System**
- [X] **Google Maps Integration**.
