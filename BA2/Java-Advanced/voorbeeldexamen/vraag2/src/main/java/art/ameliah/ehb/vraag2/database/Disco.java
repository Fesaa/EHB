package art.ameliah.ehb.vraag2.database;

import jakarta.persistence.TypedQuery;
import jakarta.persistence.criteria.CriteriaBuilder;
import jakarta.persistence.criteria.CriteriaQuery;
import jakarta.persistence.criteria.Root;
import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;
import org.hibernate.query.Query;

import java.util.List;

public class Disco {

    private static Disco instance;

    private SessionFactory factory;

    public static Disco get() {
        if (instance == null) {
            throw new RuntimeException("Disco is null");
        }
        return instance;
    }

    public Disco() throws ExceptionInInitializerError {
        if (instance != null) {
            throw new RuntimeException("Disco already init");
        }
        instance = this;
        init();
    }

    private void init() throws ExceptionInInitializerError {
        try {
             factory = (new Configuration()).configure().buildSessionFactory();
        } catch (Throwable ex) {
            System.err.println("SessionFactory creation failed." + ex);
            throw new ExceptionInInitializerError(ex);
        }
    }

    public Session getSession() {
        return factory.openSession();
    }

    public void save(Object o) {
        try (Session session = getSession()) {
            session.beginTransaction();
            session.save(o);
            session.getTransaction().commit();
        }
    }

    public <T> List<T> getTable(Class<T> clazz) {
        try (Session session = getSession()) {
            CriteriaBuilder builder = session.getCriteriaBuilder();
            CriteriaQuery<T>  criteriaQuery = builder.createQuery(clazz);
            Root<T> rootEntry = criteriaQuery.from(clazz);
            CriteriaQuery<T> all = criteriaQuery.select(rootEntry);
            TypedQuery<T> allQuery = session.createQuery(all);
            return allQuery.getResultList();
        }
    }

}
