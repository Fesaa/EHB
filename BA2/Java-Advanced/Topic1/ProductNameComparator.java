import java.util.Comparator;

public class ProductNameComparator implements Comparator<Product> {
    @Override
    public int compare(Product product, Product t1) {
        return product.getName().compareTo(t1.getName());
    }
}
