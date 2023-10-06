import java.util.*;

public class WareHouse {

    private final Set<Product> inventory = new HashSet<>();

    public boolean addProduct(Product product) {
        return this.inventory.add(product);
    }

    public boolean addAll(Collection<Product> products) {
        return this.inventory.addAll(products);
    }

    public List<Product> getOrderedByName() {
        return inventory.stream().sorted(new ProductNameComparator()).toList();
    }

    public List<Product> getOrderedByPrice() {
        return inventory.stream().sorted((p1, p2) -> p1.getPrice().compareTo(p2.getPrice())).toList();
    }

    public List<Product> getOrderedByWeight() {
        return inventory.stream().sorted(new ProductWeightComparator()).toList();
    }

    private static class ProductWeightComparator implements Comparator<Product> {
        @Override
        public int compare(Product product, Product t1) {
            return product.getWeight() - t1.getWeight();
        }
    }



}
