import java.math.BigDecimal;
import java.util.List;

public class Main {

    public static void main(String[] args) {

        Product product1 = new Product("Banana", new BigDecimal("1.50"), 13);
        Product product2 = new Product("Apple", new BigDecimal("1.75"), 8);
        Product product3 = new Product("Orange", new BigDecimal("2.00"), 10);
        Product product4 = new Product("Pineapple", new BigDecimal("3.00"), 5);

        WareHouse wareHouse = new WareHouse();
        wareHouse.addAll(List.of(product1, product2, product3, product4));

        System.out.println("Products ordered by name:");
        wareHouse.getOrderedByName().forEach(Product::printProduct);

        System.out.println("Products ordered by price:");
        wareHouse.getOrderedByPrice().forEach(Product::printProduct);

        System.out.println("Products ordered by weight:");
        wareHouse.getOrderedByWeight().forEach(Product::printProduct);

    }

}
