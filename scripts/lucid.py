"""
Utilities for updating Lucid Builder keys for import into Lucid.

Process based on Lucid key XML:

 [x] create reciprocal mappings of entity ids to entity names
 [x] create reciprocal mappings of feature/state ids to feature/state names
 [ ] for each feature write a function to get the feature data from the masterlist for each species
 [x] create scoring_item sections for each feature with scored_item entries for each entity
"""
import elementtree.ElementTree as ET
from pprint import pprint
import sys

from masterlist import get_feature


class Item(object):
    def __init__(self, **kwargs):
        for key, value in kwargs.items():
            setattr(self, key, value)

    def __unicode__(self):
        return self.name

    def __repr__(self):
        return unicode(self)


class Entity(Item):
    pass


class Feature(Item):
    @property
    def states_by_name(self):
        if not hasattr(self, "_states_by_name"):
            if hasattr(self, "states"):
                self._states_by_name = dict([(state.name.lower(), state)
                                             for state in self.states])
            else:
                self._states_by_name = {}

        return self._states_by_name


class State(Item):
    pass


class LucidKey(object):
    def __init__(self, filename):
        self.filename = filename
        self.tree = ET.parse(filename)
        items = list(self.tree.findall("items/item"))

        self.entities = []
        self.features = []

        self.entities_by_id = {}
        self.entities_by_fullname = {}
        self.states_by_id = {}
        self.feature_states = {}

        for i in items:
            if i.attrib["item_type"] == "feature":
                feature = Feature(states=[], **i.attrib)
                self.features.append(feature)
                self.feature_states.setdefault(feature.name, {})
            elif i.attrib["item_type"] == "entity":
                # Store names by id.
                self.entities_by_id[i.attrib["item_id"]] = i.attrib["name"]

                # Title capitalized names are genus names. These need to be prepended to
                # species names.
                if i.attrib["name"].istitle():
                    genus = i.attrib["name"]
                else:
                    # Create a full name from a genus name and a species name.
                    kwargs = i.attrib.copy()
                    kwargs["name"] = "%s %s" % (genus, i.attrib["name"])
                    entity = Entity(**kwargs)
                    self.entities_by_fullname[entity.name] = entity.item_id
                    self.entities.append(entity)
            elif i.attrib["item_type"] == "state":
                # Store names by id.
                state = State(**i.attrib)
                feature.states.append(state)
                self.states_by_id[state.item_id] = state.name
                self.feature_states[feature.name][state.name] = state.item_id

    @property
    def scores_container(self):
        if not hasattr(self, "_scores_container"):
            root = self.tree.getroot()
            descriptions = None
            container = None

            for e in list(root):
                if e.tag == "descriptions":
                    descriptions = e
                    print "Found descriptions"
                    break

            if descriptions is not None:
                for e in list(descriptions):
                    if e.attrib["type"] == "normal":
                        container = e
                        print "Found container"
                        break

            self._scores_container = container

        return self._scores_container

    @property
    def scores(self):
        if self.scores_container is not None:
            return list(self.scores_container)
        else:
            return []

    @property
    def features_by_name(self):
        if not hasattr(self, "_features_by_name"):
            self._features_by_name = dict([(feature.name.lower(), feature)
                                           for feature in self.features])

        return self._features_by_name

    @property
    def entities_by_name(self):
        if not hasattr(self, "_entities_by_name"):
            self._entities_by_name = dict([(entity.name.lower(), entity)
                                           for entity in self.entities])

        return self._entities_by_name

    def score_feature_state_from_data(self, feature_name, state_name, data):
        if self.scores_container is not None:
            feature_data = get_feature(data, state_name)
            if len(feature_data) > 0:
                feature = self.features_by_name[feature_name.lower()]
                state = feature.states_by_name[state_name.lower()]

                scoring_item = ET.SubElement(
                    self.scores_container,
                    "scoring_item",
                    {"item_id": state.item_id}
                )

                for entity_name, value in feature_data:
                    entity = self.entities_by_name[entity_name.lower()]
                    scored_item = ET.SubElement(
                        scoring_item,
                        "scored_item",
                        {"item_id": entity.item_id,
                         "value": value}
                    )

    def save(self, filename):
        self.tree.write(filename)


if __name__ == "__main__":
    if len(sys.argv) < 2:
        print "Usage: ./lucid.py <filename>"
        sys.exit(1)

    filename = sys.argv[1]
    print "Opening %s..." % filename
    key = LucidKey(filename)

    print "Found %s entities" % len(key.entities)
    pprint(key.entities[:10])

    print "Found %s features" % len(key.features)
    pprint(key.features[:10])