#DROP DATABASE IF EXISTS gamazon;
#CREATE DATABASE gamazon;

use gamazon;

# php artisan migrate (create 'users' table)

CREATE TABLE gamer (	id int(10) UNSIGNED unique,
						gamer_id int(10) UNSIGNED unique,						
						user_level varchar(191) NOT NULL default 'bronze',
                        redeem_likes int(10) unsigned default 0,
						PRIMARY KEY (id, gamer_id),
                        FOREIGN KEY (id) REFERENCES users(id) on delete cascade);
delimiter //
CREATE TRIGGER gamer_inc_id BEFORE INSERT ON gamer  
	FOR EACH ROW
	BEGIN     
		IF IFNULL(NEW.gamer_id,0) = 0 THEN  
		  SET NEW.gamer_id = (SELECT COUNT(1) FROM gamer) + 1;
		END IF;
    END; //
delimiter ;
CREATE TABLE company (	id int(10) UNSIGNED unique,
						company_id int(10) UNSIGNED unique,
                        image LONGTEXT,
                        description TEXT,
                        PRIMARY KEY (id, company_id),
                        FOREIGN KEY (id) REFERENCES users(id) on delete cascade);
delimiter //
CREATE TRIGGER company_inc_id BEFORE INSERT ON company  
	FOR EACH ROW
	BEGIN     
		IF IFNULL(NEW.company_id,0) = 0 THEN  
		  SET NEW.company_id = (SELECT COUNT(1) FROM company) + 1;
		END IF;
    END; //
delimiter ;
CREATE TABLE product (	product_id int(10) UNSIGNED AUTO_INCREMENT,
						id int(10) UNSIGNED,
                        company_id int(10) UNSIGNED,
                        name varchar(191) unique NOT NULL,
                        video varchar(191),
                        description TEXT,
                        category varchar(191) not null,
                        price DOUBLE NOT NULL,
                        PRIMARY KEY (product_id),
                        FOREIGN KEY (id, company_id) REFERENCES company (id, company_id) on delete cascade);
CREATE TABLE review (	review_id int(10) UNSIGNED AUTO_INCREMENT,
						product_id int(10) UNSIGNED,
                        content TEXT NOT NULL,
                        rate int(10) not null default 0,
						PRIMARY KEY (review_id),
                        FOREIGN KEY (product_id) REFERENCES product (product_id) on delete cascade);
CREATE TABLE image (	image_id int(10) UNSIGNED AUTO_INCREMENT,
						product_id int(10) UNSIGNED,
						image LONGTEXT NOT NULL,
                        thumb bit,
                        PRIMARY KEY (image_id),
                        FOREIGN KEY (product_id) REFERENCES product (product_id) on delete cascade);
CREATE TABLE write_review (	id int(10) UNSIGNED,
						gamer_id int(10) UNSIGNED,
						review_id int(10) UNSIGNED,
                        datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (id,gamer_id,review_id),
                        FOREIGN KEY (id, gamer_id) REFERENCES gamer (id, gamer_id)  on delete cascade,
                        FOREIGN KEY (review_id) REFERENCES review (review_id) on delete cascade);
CREATE TABLE like_review ( id int(10) UNSIGNED,
						gamer_id int(10) UNSIGNED,
						review_id int(10) UNSIGNED,
                        datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (id,gamer_id,review_id),
                        FOREIGN KEY (id, gamer_id) REFERENCES gamer (id, gamer_id) on delete cascade,
                        FOREIGN KEY (review_id) REFERENCES review (review_id) on delete cascade);
CREATE TABLE visit_product ( id int(10) UNSIGNED,
						gamer_id int(10) UNSIGNED,
						product_id int(10) UNSIGNED,
                        datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (id, gamer_id) REFERENCES gamer (id, gamer_id) on delete cascade,
                        FOREIGN KEY (product_id) REFERENCES product (product_id) on delete cascade);
CREATE TABLE order_product ( id int(10) UNSIGNED,
						gamer_id int(10) UNSIGNED,
						product_id int(10) UNSIGNED,
                        datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (id,gamer_id,product_id),
                        FOREIGN KEY (id, gamer_id) REFERENCES gamer (id, gamer_id) on delete cascade,
                        FOREIGN KEY (product_id) REFERENCES product (product_id) on delete cascade);
CREATE TABLE coupon (	coupon_id int(10) UNSIGNED auto_increment,
						id int(10) UNSIGNED,
						gamer_id int(10) UNSIGNED,
                        content int(10) not null,
                        datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (coupon_id),
                        FOREIGN KEY (id, gamer_id) REFERENCES gamer (id, gamer_id) on delete cascade);
                        
CREATE VIEW product_visit AS
		select product.product_id AS pid, IFNULL(count(visit_product.product_id), 0) AS visit_count
        from product join visit_product on product.product_id = visit_product.product_id
        group by product.product_id;
        
CREATE VIEW product_info AS
		select product.product_id, product.name, product.description,
            IFNULL(AVG(review.rate), 0) AS rate,
            IFNULL(count(review.review_id), 0) AS review,
            IFNULL(count(review.review_id) * AVG(review.rate), 0) AS pop_rate,
            IFNULL(visit.visit_count,0) AS visit
        from (product left join review on review.product_id = product.product_id)
			left join product_visit as visit on product.product_id = visit.pid
        group by product.product_id, product.name, product.description, visit.visit_count;
        
CREATE VIEW search AS
		SELECT product.product_id AS product_id, 
			   product.name AS name,
			   users.name AS company, 
			   product.category AS category, 
			   product.price AS price
		FROM product join users on product.id = users.id;
