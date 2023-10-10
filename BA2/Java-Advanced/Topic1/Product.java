import java.math.BigDecimal;

public class Product {

    private final String name;
    private final BigDecimal price;
    private final int weight;

    public Product(String nameAtStart, BigDecimal priceAtStart, int weight) {
        this.name = nameAtStart;
        this.price = priceAtStart;
        this.weight = weight;
    }

    public void printProduct() {
        System.out.println(this.name + ", price " + this.price + ", weight " + this.weight);
    }

    @Override
    public int hashCode() {
        return this.name.hashCode();
    }


    public String getName() {
        return name;
    }

    public BigDecimal getPrice() {
        return price;
    }

    public int getWeight() {
        return weight;
    }
}
