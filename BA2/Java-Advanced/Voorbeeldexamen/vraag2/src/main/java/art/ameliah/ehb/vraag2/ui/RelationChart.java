package art.ameliah.ehb.vraag2.ui;

import art.ameliah.ehb.vraag2.database.Disco;
import art.ameliah.ehb.vraag2.database.entity.Symptom;
import javafx.scene.chart.BarChart;
import javafx.scene.chart.CategoryAxis;
import javafx.scene.chart.NumberAxis;
import javafx.scene.chart.XYChart;

import java.util.List;

public class RelationChart extends BarChart<String, Number> {
    public RelationChart() {
        super(new CategoryAxis(), new NumberAxis());

        List<Symptom> symptoms = Disco.get().getTable(Symptom.class);
        XYChart.Series<String, Number> sys = new Series<>();
        symptoms.forEach(s -> sys.getData().add(new Data<>(s.getName(), s.getPatients().size())));

        getData().add(sys);
    }
}
